<?php

namespace App\Services\Admin\Reports;

use App\Models\Product;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InventoryReportService
{
    /**
     * Stock valuation — what your current inventory is "worth" two ways:
     * at cost (what you paid) and at retail (what you'd collect selling it all).
     * The gap between the two is your unrealized gross profit sitting on the shelf.
     */
    public function getStockValuation()
    {
        $products = Product::with('category', 'brand')->where('status', 1)->get();

        $costValue = $products->sum(fn ($p) => $p->stock * $p->cost_price);
        $retailValue = $products->sum(fn ($p) => $p->stock * $p->selling_price);

        return [
            'products'           => $products,
            'total_cost_value'   => (float) $costValue,
            'total_retail_value' => (float) $retailValue,
            'potential_profit'   => (float) ($retailValue - $costValue),
        ];
    }

    public function getLowStock()
    {
        return Product::with('category', 'brand')
            ->where('status', 1)
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock')
            ->get();
    }

    public function getOutOfStock()
    {
        return Product::with('category', 'brand')
            ->where('status', 1)
            ->where('stock', '<=', 0)
            ->get();
    }

    /**
     * Dead stock: products with zero sales in the lookback window despite having stock.
     * Tells the owner what's tying up cash on the shelf for no return.
     */
    public function getDeadStock(int $daysWithoutSale = 60)
    {
        $cutoff = Carbon::now()->subDays($daysWithoutSale);

        $soldProductIds = SaleItem::query()
            ->join('sales', 'sales.id', '=', 'sale_items.sale_id')
            ->where('sales.status', 'completed')
            ->where('sales.created_at', '>=', $cutoff)
            ->distinct()
            ->pluck('sale_items.product_id');

        return Product::with('category', 'brand')
            ->where('status', 1)
            ->where('stock', '>', 0)
            ->whereNotIn('id', $soldProductIds)
            ->get();
    }

    /**
     * Stock movement: net IN (purchases + returns restocked) vs OUT (sales) per product,
     * over a date range. This is the audit-trail report — "why is stock at X".
     */
    public function getStockMovement(string $from, string $to)
    {
        $purchasedIn = DB::table('purchase_items')
            ->join('purchases', 'purchases.id', '=', 'purchase_items.purchase_id')
            ->where('purchases.status', 'received')
            ->whereDate('purchases.purchase_date', '>=', $from)
            ->whereDate('purchases.purchase_date', '<=', $to)
            ->selectRaw('purchase_items.product_id, SUM(purchase_items.quantity) as qty')
            ->groupBy('purchase_items.product_id')
            ->pluck('qty', 'product_id');

        $soldOut = DB::table('sale_items')
            ->join('sales', 'sales.id', '=', 'sale_items.sale_id')
            ->where('sales.status', 'completed')
            ->whereDate('sales.created_at', '>=', $from)
            ->whereDate('sales.created_at', '<=', $to)
            ->selectRaw('sale_items.product_id, SUM(sale_items.quantity) as qty')
            ->groupBy('sale_items.product_id')
            ->pluck('qty', 'product_id');

        $returnedIn = DB::table('return_items')
            ->join('returns', 'returns.id', '=', 'return_items.return_id')
            ->where('returns.restocked', 1)
            ->whereDate('returns.created_at', '>=', $from)
            ->whereDate('returns.created_at', '<=', $to)
            ->selectRaw('return_items.product_id, SUM(return_items.quantity_returned) as qty')
            ->groupBy('return_items.product_id')
            ->pluck('qty', 'product_id');

        $productIds = collect()
            ->merge($purchasedIn->keys())
            ->merge($soldOut->keys())
            ->merge($returnedIn->keys())
            ->unique();

        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        return $productIds->map(function ($id) use ($products, $purchasedIn, $soldOut, $returnedIn) {
            $product = $products->get($id);
            $in = (int) ($purchasedIn[$id] ?? 0) + (int) ($returnedIn[$id] ?? 0);
            $out = (int) ($soldOut[$id] ?? 0);

            return [
                'product'      => $product,
                'purchased_in' => (int) ($purchasedIn[$id] ?? 0),
                'returned_in'  => (int) ($returnedIn[$id] ?? 0),
                'sold_out'     => $out,
                'net_change'   => $in - $out,
                'current_stock'=> $product->stock ?? 0,
            ];
        })->filter(fn ($row) => $row['product'] !== null)->values();
    }
}