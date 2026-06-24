<?php

namespace App\Services\Admin;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PosService
{
    /* =========================
       PRODUCT / CUSTOMER LOOKUPS
    ==========================*/

    public function searchProducts(?string $term, ?int $categoryId = null)
    {
        $products = Product::query()
            ->where('status', 1)
            ->when($term, function ($q) use ($term) {
                $q->where(function ($q2) use ($term) {
                    $q2->where('name', 'like', "%{$term}%")
                       ->orWhere('sku', 'like', "%{$term}%")
                       ->orWhere('barcode', 'like', "%{$term}%");
                });
            })
            ->when($categoryId, fn ($q) => $q->where('category_id', $categoryId))
            ->orderBy('name')
            ->limit(60)
            ->get(['id', 'name', 'sku', 'barcode', 'selling_price', 'cost_price', 'stock', 'image', 'category_id']);

        return $this->withImageUrls($products);
    }

    public function findByBarcode(string $barcode)
    {
        $product = Product::where('barcode', $barcode)->where('status', 1)->first();

        if (!$product) {
            return null;
        }

        $product->image_url = $this->resolveImageUrl($product->image);
        return $product;
    }

    public function searchCustomers(?string $term)
    {
        return Customer::query()
            ->where('status', 1)
            ->when($term, function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('phone', 'like', "%{$term}%");
            })
            ->limit(20)
            ->get(['id', 'name', 'phone']);
    }

    protected function withImageUrls($products)
    {
        return $products->map(function ($p) {
            $p->image_url = $this->resolveImageUrl($p->image);
            return $p;
        });
    }

    protected function resolveImageUrl(?string $path): string
    {
        return $path ? asset('storage/' . $path) : asset('backend/assets/img/noimage.png');
    }

    /* =========================
       TOTALS CALCULATION
       $forCheckout = true ONLY when called inside an actual DB::transaction
       that is about to mutate stock (checkout/hold). For live preview while
       the cashier is still building the cart, NEVER lock rows — locking
       during preview would make every terminal queue on popular products.
    ==========================*/

    public function calculateTotals(array $items, float $overallDiscount = 0, float $tax = 0, bool $forCheckout = false): array
    {
        $subtotal = 0;
        $resolvedItems = [];

        foreach ($items as $item) {
            $query = Product::query();
            if ($forCheckout) {
                $query->lockForUpdate();
            }
            $product = $query->findOrFail($item['product_id']);

            $qty = (int) $item['quantity'];
            $lineDiscount = (float) ($item['discount'] ?? 0);

            $this->assertStockAvailable($product, $qty);

            $lineTotal = ((float) $product->selling_price * $qty) - $lineDiscount;
            $subtotal += $lineTotal;

            $resolvedItems[] = [
                'product'  => $product,
                'quantity' => $qty,
                'discount' => $lineDiscount,
                'total'    => $lineTotal,
            ];
        }

        $grandTotal = max($subtotal - $overallDiscount + $tax, 0);

        return [
            'subtotal'    => $subtotal,
            'grand_total' => $grandTotal,
            'items'       => $resolvedItems,
        ];
    }

    protected function assertStockAvailable(Product $product, int $requestedQty): void
    {
        if ($requestedQty > $product->stock) {
            throw ValidationException::withMessages([
                'items' => "Insufficient stock for \"{$product->name}\". Available: {$product->stock}, requested: {$requestedQty}.",
            ]);
        }
    }

    /* =========================
       CHECKOUT
    ==========================*/

    public function checkout(array $data): Sale
    {
        return DB::transaction(function () use ($data) {

            $discount = (float) ($data['discount'] ?? 0);
            $tax = (float) ($data['tax'] ?? 0);

            // forCheckout = true: locks rows now, inside this transaction, right
            // before we mutate stock — this is the only place locking belongs.
            $calc = $this->calculateTotals($data['items'], $discount, $tax, true);

            $paid = (float) $data['paid_amount'];
            $due = max($calc['grand_total'] - $paid, 0);

            $sale = Sale::create([
                'invoice_no'         => $this->generateInvoiceNumber(),
                'customer_id'        => $data['customer_id'] ?? null,
                'subtotal'           => $calc['subtotal'],
                'discount'           => $discount,
                'tax'                => $tax,
                'grand_total'        => $calc['grand_total'],
                'paid_amount'        => $paid,
                'due_amount'         => $due,
                'payment_method'     => $data['payment_method'],
                'payment_reference'  => $data['payment_reference'] ?? null,
                'payment_status'     => $this->resolvePaymentStatus($calc['grand_total'], $paid),
                'status'             => 'completed',
                'notes'              => $data['notes'] ?? null,
                'created_by'         => $this->resolveCreatedBy(),
            ]);

            foreach ($calc['items'] as $item) {
                $product = $item['product'];

                SaleItem::create([
                    'sale_id'       => $sale->id,
                    'product_id'    => $product->id,
                    'product_name'  => $product->name,
                    'product_sku'   => $product->sku,
                    'cost_price'    => $product->cost_price,
                    'selling_price' => $product->selling_price,
                    'quantity'      => $item['quantity'],
                    'discount'      => $item['discount'],
                    'total'         => $item['total'],
                ]);

                $product->decrement('stock', $item['quantity']);
            }

            return $sale->load('items', 'customer');
        });
    }

    /* =========================
       HOLD ORDERS — saved as real Sale rows with status='held'.
       No stock is touched until the order is resumed and actually completed.
    ==========================*/

    public function holdOrder(array $data): Sale
    {
        return DB::transaction(function () use ($data) {

            $discount = (float) ($data['discount'] ?? 0);
            $tax = (float) ($data['tax'] ?? 0);

            $calc = $this->calculateTotals($data['items'], $discount, $tax, true);

            $paid = (float) ($data['paid_amount'] ?? 0);

            $sale = Sale::create([
                'invoice_no'         => $this->generateInvoiceNumber(),
                'customer_id'        => $data['customer_id'] ?? null,
                'subtotal'           => $calc['subtotal'],
                'discount'           => $discount,
                'tax'                => $tax,
                'grand_total'        => $calc['grand_total'],
                'paid_amount'        => $paid,
                'due_amount'         => max($calc['grand_total'] - $paid, 0),
                'payment_method'     => $data['payment_method'] ?? 'cash',
                'payment_status'     => $this->resolvePaymentStatus($calc['grand_total'], $paid),
                'status'             => 'held',
                'notes'              => $data['notes'] ?? null,
                'created_by'         => $this->resolveCreatedBy(),
            ]);

            foreach ($calc['items'] as $item) {
                $product = $item['product'];

                SaleItem::create([
                    'sale_id'       => $sale->id,
                    'product_id'    => $product->id,
                    'product_name'  => $product->name,
                    'product_sku'   => $product->sku,
                    'cost_price'    => $product->cost_price,
                    'selling_price' => $product->selling_price,
                    'quantity'      => $item['quantity'],
                    'discount'      => $item['discount'],
                    'total'         => $item['total'],
                ]);
                // Deliberately no stock decrement — order is not yet sold.
            }

            return $sale;
        });
    }

    public function getHeldOrders()
    {
        return Sale::where('status', 'held')->with('customer')->latest()->get();
    }

    public function resumeHeldOrder(int $id): array
    {
        return DB::transaction(function () use ($id) {
            $sale = Sale::where('status', 'held')->with('items')->findOrFail($id);

            // Use CURRENT product price/stock on resume — prices may have
            // changed since the order was held, and we want the cart to
            // reflect reality, not a stale snapshot.
            $items = $sale->items->map(function ($item) {
                $product = Product::find($item->product_id);
                return [
                    'product_id' => $item->product_id,
                    'name'       => $item->product_name,
                    'sku'        => $item->product_sku,
                    'price'      => (float) ($product->selling_price ?? $item->selling_price),
                    'stock'      => (float) ($product->stock ?? 0),
                    'qty'        => $item->quantity,
                    'discount'   => (float) $item->discount,
                ];
            })->values();

            $customerId = $sale->customer_id;

            $sale->items()->delete();
            $sale->delete();

            return ['items' => $items, 'customer_id' => $customerId];
        });
    }

    public function deleteHeldOrder(int $id): void
    {
        $sale = Sale::where('status', 'held')->findOrFail($id);
        $sale->items()->delete();
        $sale->delete();
    }

    /* =========================
       RECENT COMPLETED SALES
    ==========================*/

    public function getRecentSales(int $limit = 20)
    {
        return Sale::where('status', 'completed')
            ->with('customer')
            ->latest()
            ->limit($limit)
            ->get();
    }

    /* =========================
       HELPERS
    ==========================*/

    protected function generateInvoiceNumber(): string
    {
        $date = now()->format('Ymd');
        $count = Sale::whereDate('created_at', now())->count() + 1;
        return "INV-{$date}-" . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    protected function resolvePaymentStatus(float $total, float $paid): string
    {
        if ($paid <= 0) return 'unpaid';
        if ($paid >= $total) return 'paid';
        return 'partial';
    }

    protected function resolveCreatedBy(): ?int
    {
        $id = Auth::guard('admin')->id();
        return $id && Admin::where('id', $id)->exists() ? $id : null;
    }

    public function getSaleForReceipt(int $saleId): Sale
    {
        return Sale::with('items', 'customer', 'creator')->findOrFail($saleId);
    }
}