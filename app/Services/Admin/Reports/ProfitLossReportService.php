<?php

namespace App\Services\Admin\Reports;

use App\Models\SaleItem;
use App\Models\Sale;
use App\Models\Expense;
use App\Models\SaleReturn;

class ProfitLossReportService
{
    /**
     * The real P&L: Revenue − COGS − Returns (refunded) − Operating Expenses = Net Profit.
     * This is the single most important report in the whole system for a shop owner.
     */
    public function getProfitLoss(string $from, string $to): array
    {
        $itemsQuery = SaleItem::query()
            ->join('sales', 'sales.id', '=', 'sale_items.sale_id')
            ->where('sales.status', 'completed')
            ->whereDate('sales.created_at', '>=', $from)
            ->whereDate('sales.created_at', '<=', $to);

        $revenue = (clone $itemsQuery)->sum('sale_items.total');
        $cogs = (clone $itemsQuery)->selectRaw('SUM(sale_items.cost_price * sale_items.quantity) as cogs')->value('cogs') ?? 0;
        $grossProfit = $revenue - $cogs;

        $totalRefunds = SaleReturn::whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->sum('refund_amount');

        $totalExpenses = Expense::whereDate('expense_date', '>=', $from)->whereDate('expense_date', '<=', $to)->sum('amount');

        $netProfit = $grossProfit - $totalRefunds - $totalExpenses;

        return [
            'revenue'         => (float) $revenue,
            'cogs'            => (float) $cogs,
            'gross_profit'    => (float) $grossProfit,
            'gross_margin_pct'=> $revenue > 0 ? round(($grossProfit / $revenue) * 100, 2) : 0,
            'total_refunds'   => (float) $totalRefunds,
            'total_expenses'  => (float) $totalExpenses,
            'net_profit'      => (float) $netProfit,
            'net_margin_pct'  => $revenue > 0 ? round(($netProfit / $revenue) * 100, 2) : 0,
        ];
    }

    public function getMonthlyTrend(int $year)
    {
        $months = collect(range(1, 12));

        return $months->map(function ($m) use ($year) {
            $from = sprintf('%d-%02d-01', $year, $m);
            $to = date('Y-m-t', strtotime($from));
            $data = $this->getProfitLoss($from, $to);

            return [
                'month'      => date('M', strtotime($from)),
                'revenue'    => $data['revenue'],
                'net_profit' => $data['net_profit'],
            ];
        });
    }

    public function getProfitByCategory(string $from, string $to)
    {
        return SaleItem::query()
            ->join('sales', 'sales.id', '=', 'sale_items.sale_id')
            ->join('products', 'products.id', '=', 'sale_items.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->where('sales.status', 'completed')
            ->whereDate('sales.created_at', '>=', $from)
            ->whereDate('sales.created_at', '<=', $to)
            ->selectRaw('categories.id, categories.name,
                         SUM(sale_items.total) as revenue,
                         SUM(sale_items.cost_price * sale_items.quantity) as cogs,
                         SUM(sale_items.total) - SUM(sale_items.cost_price * sale_items.quantity) as profit')
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('profit')
            ->get();
    }
}