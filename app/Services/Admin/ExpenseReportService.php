<?php

namespace App\Services\Admin;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Sale;
use Carbon\Carbon;

class ExpenseReportService
{
    public function getSummary(?string $from = null, ?string $to = null): array
    {
        $from = $from ?: now()->startOfMonth()->toDateString();
        $to = $to ?: now()->endOfMonth()->toDateString();

        $totalExpense = Expense::betweenDates($from, $to)->sum('amount');

        $totalSales = Sale::where('status', 'completed')
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->sum('grand_total');

        $byCategory = Expense::betweenDates($from, $to)
            ->with('category')
            ->selectRaw('expense_category_id, SUM(amount) as total')
            ->groupBy('expense_category_id')
            ->orderByDesc('total')
            ->get()
            ->map(fn ($row) => [
                'category' => $row->category->name ?? 'Uncategorized',
                'total'    => (float) $row->total,
            ]);

        $byPaymentMethod = Expense::betweenDates($from, $to)
            ->selectRaw('payment_method, SUM(amount) as total')
            ->groupBy('payment_method')
            ->pluck('total', 'payment_method');

        return [
            'from'              => $from,
            'to'                => $to,
            'total_expense'     => (float) $totalExpense,
            'total_sales'       => (float) $totalSales,
            'net_after_expense' => (float) $totalSales - (float) $totalExpense,
            'by_category'       => $byCategory,
            'by_payment_method' => $byPaymentMethod,
        ];
    }

    public function getMonthlyTrend(int $year): array
    {
        $rows = Expense::whereYear('expense_date', $year)
            ->selectRaw('MONTH(expense_date) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        $data = [];
        for ($m = 1; $m <= 12; $m++) {
            $data[] = round((float) ($rows[$m] ?? 0), 2);
        }

        return [
            'labels' => ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            'data'   => $data,
        ];
    }

    public function getTopCategories(?string $from = null, ?string $to = null, int $limit = 5)
    {
        $from = $from ?: now()->startOfMonth()->toDateString();
        $to = $to ?: now()->endOfMonth()->toDateString();

        return Expense::betweenDates($from, $to)
            ->with('category')
            ->selectRaw('expense_category_id, SUM(amount) as total, COUNT(*) as count')
            ->groupBy('expense_category_id')
            ->orderByDesc('total')
            ->limit($limit)
            ->get();
    }
}