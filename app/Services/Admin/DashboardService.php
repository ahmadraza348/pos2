<?php

namespace App\Services\Admin;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardService
{
    public function getDashboardData(?int $year = null): array
    {
        $year = $year ?: now()->year;

        return [
            'cards'              => $this->getSummaryCards(),
            'counts'             => $this->getCounts(),
            'chart'              => $this->getMonthlySalesPurchaseChart($year),
            'available_years'    => $this->getAvailableYears(),
            'selected_year'       => $year,
            'recently_added'     => $this->getRecentlyAddedProducts(),
            'low_stock_products' => $this->getLowStockProducts(),
            'recent_sales'       => $this->getRecentSales(),
        ];
    }

    /* =========================
       TOP SUMMARY CARDS
    ==========================*/
    protected function getSummaryCards(): array
    {
        $totalPurchaseDue = Purchase::where('status', '!=', 'cancelled')->sum('due_amount');
        $totalSalesDue    = Sale::where('status', 'completed')->sum('due_amount');
        $totalSaleAmount  = Sale::where('status', 'completed')->sum('grand_total');

        // Profit = (selling_price - cost_price) * qty across all completed sale items,
        // minus refunded amounts so voided/returned stock doesn't inflate profit.
        $grossProfit = SaleItem::query()
            ->join('sales', 'sales.id', '=', 'sale_items.sale_id')
            ->where('sales.status', 'completed')
            ->selectRaw('SUM((sale_items.selling_price - sale_items.cost_price) * sale_items.quantity - sale_items.discount) as profit')
            ->value('profit') ?? 0;

        $todaySales = Sale::where('status', 'completed')->whereDate('created_at', today())->sum('grand_total');

        return [
            'total_purchase_due' => (float) $totalPurchaseDue,
            'total_sales_due'    => (float) $totalSalesDue,
            'total_sale_amount'  => (float) $totalSaleAmount,
            'gross_profit'       => (float) $grossProfit,
            'today_sales'        => (float) $todaySales,
        ];
    }

    /* =========================
       ENTITY COUNTS
    ==========================*/
    protected function getCounts(): array
    {
        return [
            'customers'         => Customer::count(),
            'suppliers'         => Supplier::count(),
            'purchase_invoices' => Purchase::count(),
            'sales_invoices'    => Sale::where('status', 'completed')->count(),
            'held_orders'       => Sale::where('status', 'held')->count(),
            'products'          => Product::count(),
        ];
    }

    /* =========================
       SALES VS PURCHASE CHART (per month, selected year)
    ==========================*/
    protected function getMonthlySalesPurchaseChart(int $year): array
    {
        $sales = Sale::where('status', 'completed')
            ->whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, SUM(grand_total) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        $purchases = Purchase::where('status', '!=', 'cancelled')
            ->whereYear('purchase_date', $year)
            ->selectRaw('MONTH(purchase_date) as month, SUM(total_amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        $salesData = [];
        $purchaseData = [];

        for ($m = 1; $m <= 12; $m++) {
            $salesData[] = round((float) ($sales[$m] ?? 0), 2);
            $purchaseData[] = round((float) ($purchases[$m] ?? 0), 2);
        }

        return [
            'labels'    => ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            'sales'     => $salesData,
            'purchases' => $purchaseData,
        ];
    }

    protected function getAvailableYears(): array
    {
        $saleYears = Sale::selectRaw('DISTINCT YEAR(created_at) as y')->pluck('y');
        $purchaseYears = Purchase::selectRaw('DISTINCT YEAR(purchase_date) as y')->pluck('y');

        $years = $saleYears->merge($purchaseYears)->unique()->sort()->values()->all();

        // Always include the current year even if there's no data yet.
        if (!in_array(now()->year, $years)) {
            $years[] = now()->year;
        }

        return collect($years)->sort()->reverse()->values()->all();
    }

    /* =========================
       RECENTLY ADDED PRODUCTS
    ==========================*/
    protected function getRecentlyAddedProducts(int $limit = 5)
    {
        return Product::with('category')
            ->latest()
            ->limit($limit)
            ->get(['id', 'name', 'sku', 'selling_price', 'image', 'category_id']);
    }

    /* =========================
       LOW STOCK PRODUCTS
       Replaces the template's "Expired Products" — your schema tracks
       minimum_stock, not expiry dates, so this is the equivalent alert
       that's actually meaningful for this business.
    ==========================*/
    protected function getLowStockProducts(int $limit = 8)
    {
        return Product::with('category', 'brand')
            ->where('status', 1)
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock')
            ->limit($limit)
            ->get(['id', 'name', 'sku', 'stock', 'minimum_stock', 'category_id', 'brand_id']);
    }

    /* =========================
       RECENT SALES
    ==========================*/
    protected function getRecentSales(int $limit = 6)
    {
        return Sale::with('customer')
            ->where('status', 'completed')
            ->latest()
            ->limit($limit)
            ->get(['id', 'invoice_no', 'customer_id', 'grand_total', 'payment_status', 'created_at']);
    }
}