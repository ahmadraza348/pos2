<?php

namespace App\Services\Admin\Reports;

use App\Models\SaleReturn;

class ReturnReportService
{
    public function getSummary(string $from, string $to): array
    {
        $base = SaleReturn::whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);

        return [
            'total_refunded' => (float) (clone $base)->sum('refund_amount'),
            'return_count'   => (clone $base)->count(),
        ];
    }

    public function getByReason(string $from, string $to)
    {
        return SaleReturn::whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->whereNotNull('reason')
            ->selectRaw('reason, COUNT(*) as count, SUM(refund_amount) as total')
            ->groupBy('reason')
            ->orderByDesc('count')
            ->get();
    }

    public function getDetailed(array $filters)
    {
        return SaleReturn::with('sale', 'customer')
            ->when($filters['from'] ?? null, fn ($q, $v) => $q->whereDate('created_at', '>=', $v))
            ->when($filters['to'] ?? null, fn ($q, $v) => $q->whereDate('created_at', '<=', $v))
            ->latest()
            ->paginate(25)
            ->withQueryString();
    }
}