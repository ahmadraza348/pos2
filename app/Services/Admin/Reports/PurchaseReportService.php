<?php

namespace App\Services\Admin\Reports;

use App\Models\Purchase;
use App\Models\PurchaseItem;

class PurchaseReportService
{
    public function getSummary(string $from, string $to): array
    {
        $base = Purchase::where('status', '!=', 'cancelled')
            ->whereDate('purchase_date', '>=', $from)
            ->whereDate('purchase_date', '<=', $to);

        return [
            'total_purchase'   => (float) (clone $base)->sum('total_amount'),
            'total_paid'       => (float) (clone $base)->sum('paid_amount'),
            'total_due'        => (float) (clone $base)->sum('due_amount'),
            'invoice_count'    => (clone $base)->count(),
        ];
    }

    public function getDailyTrend(string $from, string $to)
    {
        return Purchase::where('status', '!=', 'cancelled')
            ->whereDate('purchase_date', '>=', $from)
            ->whereDate('purchase_date', '<=', $to)
            ->selectRaw('purchase_date as date, SUM(total_amount) as total')
            ->groupBy('purchase_date')
            ->orderBy('purchase_date')
            ->get();
    }

    public function getBySupplier(string $from, string $to)
    {
        return Purchase::where('status', '!=', 'cancelled')
            ->whereDate('purchase_date', '>=', $from)
            ->whereDate('purchase_date', '<=', $to)
            ->with('supplier')
            ->selectRaw('supplier_id, SUM(total_amount) as total, SUM(due_amount) as due, COUNT(*) as count')
            ->groupBy('supplier_id')
            ->orderByDesc('total')
            ->get();
    }

    public function getMostPurchasedProducts(string $from, string $to, int $limit = 10)
    {
        return PurchaseItem::query()
            ->join('purchases', 'purchases.id', '=', 'purchase_items.purchase_id')
            ->join('products', 'products.id', '=', 'purchase_items.product_id')
            ->where('purchases.status', '!=', 'cancelled')
            ->whereDate('purchases.purchase_date', '>=', $from)
            ->whereDate('purchases.purchase_date', '<=', $to)
            ->selectRaw('products.id as product_id, products.name, products.sku,
                         SUM(purchase_items.quantity) as qty_purchased,
                         SUM(purchase_items.total) as total_cost')
            ->groupBy('products.id', 'products.name', 'products.sku')
            ->orderByDesc('qty_purchased')
            ->limit($limit)
            ->get();
    }

    public function getDetailedPurchases(array $filters)
    {
        return Purchase::query()
            ->with('supplier')
            ->when($filters['from'] ?? null, fn ($q, $v) => $q->whereDate('purchase_date', '>=', $v))
            ->when($filters['to'] ?? null, fn ($q, $v) => $q->whereDate('purchase_date', '<=', $v))
            ->when($filters['supplier_id'] ?? null, fn ($q, $v) => $q->where('supplier_id', $v))
            ->when($filters['status'] ?? null, fn ($q, $v) => $q->where('status', $v))
            ->latest('purchase_date')
            ->paginate(25)
            ->withQueryString();
    }
}