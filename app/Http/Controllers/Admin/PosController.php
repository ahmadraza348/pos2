<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PosCheckoutRequest;
use App\Http\Requests\Admin\HoldOrderRequest;
use App\Services\Admin\PosService;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PosController extends Controller
{
    protected PosService $posService;

    public function __construct(PosService $posService)
    {
        $this->posService = $posService;
    }

    public function index()
    {
        return view('backend.pos.pos', [
            'categories' => Category::where('status', 1)->get(),
        ]);
    }

    public function searchProducts(Request $request)
    {
        $products = $this->posService->searchProducts(
            $request->query('term'),
            $request->query('category_id')
        );

        return response()->json(['success' => true, 'data' => $products]);
    }

    public function searchByBarcode(Request $request)
    {
        $request->validate(['barcode' => 'required|string']);

        $product = $this->posService->findByBarcode($request->barcode);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'No product found for this barcode.'], 404);
        }

        return response()->json(['success' => true, 'data' => $product]);
    }

    public function searchCustomers(Request $request)
    {
        $customers = $this->posService->searchCustomers($request->query('term'));
        return response()->json(['success' => true, 'data' => $customers]);
    }

    public function storeCustomer(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|max:255',
            'phone'   => 'nullable|string|max:30',
            'city'    => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ]);

        $customer = Customer::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'city'    => $request->city,
            'address' => $request->address,
            'opening_balance' => 0,
            // 'balance_type'    => '', 
            'status'  => 1,
        ]);

        return response()->json(['success' => true, 'data' => $customer]);
    }

    public function calculateTotals(Request $request)
    {
        $request->validate([
            'items'               => 'required|array|min:1',
            'items.*.product_id'  => 'required|exists:products,id',
            'items.*.quantity'    => 'required|integer|min:1',
            'items.*.discount'    => 'nullable|numeric|min:0',
            'discount'            => 'nullable|numeric|min:0',
            'tax'                 => 'nullable|numeric|min:0',
        ]);

        try {
            // forCheckout = false: this is a live preview only, no locking.
            $calc = $this->posService->calculateTotals(
                $request->items,
                (float) $request->input('discount', 0),
                (float) $request->input('tax', 0),
                false
            );

            return response()->json([
                'success'     => true,
                'subtotal'    => $calc['subtotal'],
                'grand_total' => $calc['grand_total'],
            ]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function checkout(PosCheckoutRequest $request)
    {
        try {
            $sale = $this->posService->checkout($request->validated());

            return response()->json([
                'success'     => true,
                'message'     => 'Sale completed successfully.',
                'sale_id'     => $sale->id,
                'invoice_no'  => $sale->invoice_no,
                'receipt_url' => route('pos.receipt', $sale->id),
            ]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        } catch (\Throwable $e) {
            report($e);
            return response()->json(['success' => false, 'message' => 'Something went wrong while processing the sale.'], 500);
        }
    }

    public function hold(HoldOrderRequest $request)
    {
        try {
            $sale = $this->posService->holdOrder($request->validated());

            return response()->json([
                'success'    => true,
                'message'    => "Order held as {$sale->invoice_no}.",
                'sale_id'    => $sale->id,
            ]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        } catch (\Throwable $e) {
            report($e);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function heldOrders()
    {
        $orders = $this->posService->getHeldOrders();
        return response()->json(['success' => true, 'data' => $orders]);
    }

    public function resumeHeldOrder(int $id)
    {
        try {
            $data = $this->posService->resumeHeldOrder($id);
            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Throwable $e) {
            report($e);
            return response()->json(['success' => false, 'message' => 'Could not resume this order.'], 500);
        }
    }

    public function deleteHeldOrder(int $id)
    {
        $this->posService->deleteHeldOrder($id);
        return response()->json(['success' => true, 'message' => 'Held order deleted.']);
    }

    public function recentSales()
    {
        $sales = $this->posService->getRecentSales();
        return response()->json(['success' => true, 'data' => $sales]);
    }

    public function receipt(int $id)
    {
        $sale = $this->posService->getSaleForReceipt($id);
        return view('backend.pos.receipt', compact('sale'));
    }
}