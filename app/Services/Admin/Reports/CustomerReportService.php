<?php

namespace App\Services\Admin\Reports;

use App\Models\Customer;
use App\Models\Sale;

class CustomerReportService
{
    public function getLedger(int $customerId, ?string $from = null, ?string $to = null)
    {
        return Sale::where('customer_id', $customerId)
            ->where('status', 'completed')
            ->when($from, fn ($q, $v) => $q->whereDate('created_at', '>=', $v))
            ->when($to, fn ($q, $v) => $q->whereDate('created_at', '<=', $v))
            ->orderBy('created_at')
            ->get();
    }

    public function getCustomersWithDue()
    {
        return Customer::query()
            ->whereHas('sales', fn ($q) => $q->where('due_amount', '>', 0)->where('status', 'completed'))
            ->withSum(['sales as total_due' => fn ($q) => $q->where('status', 'completed')], 'due_amount')
            ->orderByDesc('total_due')
            ->get();
    }

    public function getTopCustomersByLifetimeValue(int $limit = 15)
    {
        return Customer::withSum(['sales as lifetime_value' => fn ($q) => $q->where('status', 'completed')], 'grand_total')
            ->orderByDesc('lifetime_value')
            ->limit($limit)
            ->get();
    }
}