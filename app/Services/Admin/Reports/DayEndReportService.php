<?php

namespace App\Services\Admin\Reports;

use App\Models\Sale;
use App\Models\SaleReturn;
use App\Models\Expense;

class DayEndReportService
{
    public function getReport(string $date, ?int $cashierId = null): array
    {
        $salesQuery = Sale::where('status', 'completed')
            ->whereDate('created_at', $date)
            ->when($cashierId, fn ($q) => $q->where('created_by', $cashierId));

        $byMethod = (clone $salesQuery)
            ->selectRaw('payment_method, SUM(grand_total) as total, COUNT(*) as count')
            ->groupBy('payment_method')
            ->get()
            ->keyBy('payment_method');

        $totalSales = (clone $salesQuery)->sum('grand_total');
        $totalDue = (clone $salesQuery)->sum('due_amount');
        $invoiceCount = (clone $salesQuery)->count();

        $cashRefunds = SaleReturn::whereDate('created_at', $date)
            ->where('refund_method', 'cash')
            ->when($cashierId, fn ($q) => $q->where('created_by', $cashierId))
            ->sum('refund_amount');

        $cashExpenses = Expense::whereDate('expense_date', $date)
            ->where('payment_method', 'cash')
            ->when($cashierId, fn ($q) => $q->where('created_by', $cashierId))
            ->sum('amount');

        $cashSales = (float) ($byMethod['cash']->total ?? 0);
        $expectedCashInDrawer = $cashSales - $cashRefunds - $cashExpenses;

        return [
            'date'                   => $date,
            'invoice_count'          => $invoiceCount,
            'total_sales'            => (float) $totalSales,
            'total_due'              => (float) $totalDue,
            'cash_sales'             => $cashSales,
            'card_sales'             => (float) ($byMethod['card']->total ?? 0),
            'bank_sales'             => (float) ($byMethod['bank_transfer']->total ?? 0),
            'cash_refunds'           => (float) $cashRefunds,
            'cash_expenses'          => (float) $cashExpenses,
            'expected_cash_in_drawer'=> $expectedCashInDrawer,
            'by_method'              => $byMethod,
        ];
    }

    public function getCashierBreakdown(string $date)
    {
        return Sale::where('status', 'completed')
            ->whereDate('created_at', $date)
            ->with('creator')
            ->selectRaw('created_by, SUM(grand_total) as total, COUNT(*) as count')
            ->groupBy('created_by')
            ->get();
    }
}