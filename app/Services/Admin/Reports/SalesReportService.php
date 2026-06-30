<?php

namespace App\Services\Admin\Reports;

use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;

class SalesReportService
{
    public function getSummary(string $from, string $to): array
    {
        $base = Sale::where('status', 'completed')->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);

        return [
            'total_sales'       => (float) (clone $base)->sum('grand_total'),
            'total_paid'        => (float) (clone $base)->sum('paid_amount'),
            'total_due'         => (float) (clone $base)->sum('due_amount'),
            'total_discount'    => (float) (clone $base)->sum('discount'),
            'total_tax'         => (float) (clone $base)->sum('tax'),
            'invoice_count'     => (clone $base)->count(),
            'avg_invoice_value' => (clone $base)->count() > 0 ? (float) (clone $base)->avg('grand_total') : 0,
        ];
    }

    public function getDailyTrend(string $from, string $to)
    {
        return Sale::where('status', 'completed')
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->selectRaw('DATE(created_at) as date, SUM(grand_total) as total, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    public function getByPaymentMethod(string $from, string $to)
    {
        return Sale::where('status', 'completed')
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->selectRaw('payment_method, SUM(grand_total) as total, COUNT(*) as count')
            ->groupBy('payment_method')
            ->get();
    }

    public function getByCashier(string $from, string $to)
    {
        return Sale::where('status', 'completed')
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->with('creator')
            ->selectRaw('created_by, SUM(grand_total) as total, COUNT(*) as count')
            ->groupBy('created_by')
            ->orderByDesc('total')
            ->get();
    }

    public function getTopCustomers(string $from, string $to, int $limit = 10)
    {
        return Sale::where('status', 'completed')
            ->whereNotNull('customer_id')
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->with('customer')
            ->selectRaw('customer_id, SUM(grand_total) as total, COUNT(*) as count')
            ->groupBy('customer_id')
            ->orderByDesc('total')
            ->limit($limit)
            ->get();
    }

    public function getTopSellingProducts(string $from, string $to, int $limit = 10)
    {
        return SaleItem::query()
            ->join('sales', 'sales.id', '=', 'sale_items.sale_id')
            ->where('sales.status', 'completed')
            ->whereDate('sales.created_at', '>=', $from)
            ->whereDate('sales.created_at', '<=', $to)
            ->selectRaw('sale_items.product_id, sale_items.product_name, sale_items.product_sku,
                         SUM(sale_items.quantity) as qty_sold,
                         SUM(sale_items.total) as revenue')
            ->groupBy('sale_items.product_id', 'sale_items.product_name', 'sale_items.product_sku')
            ->orderByDesc('qty_sold')
            ->limit($limit)
            ->get();
    }

    public function getDetailedSales(array $filters)
    {
        return Sale::query()
            ->with('customer', 'creator')
            ->where('status', 'completed')
            ->when($filters['from'] ?? null, fn ($q, $v) => $q->whereDate('created_at', '>=', $v))
            ->when($filters['to'] ?? null, fn ($q, $v) => $q->whereDate('created_at', '<=', $v))
            ->when($filters['customer_id'] ?? null, fn ($q, $v) => $q->where('customer_id', $v))
            ->when($filters['payment_method'] ?? null, fn ($q, $v) => $q->where('payment_method', $v))
            ->latest()
            ->paginate(25)
            ->withQueryString();
    }
}