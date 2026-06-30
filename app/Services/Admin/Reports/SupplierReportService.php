<?php

namespace App\Services\Admin\Reports;

use App\Models\Supplier;
use App\Models\Purchase;

class SupplierReportService
{
    public function getLedger(int $supplierId, ?string $from = null, ?string $to = null)
    {
        return Purchase::where('supplier_id', $supplierId)
            ->where('status', '!=', 'cancelled')
            ->when($from, fn ($q, $v) => $q->whereDate('purchase_date', '>=', $v))
            ->when($to, fn ($q, $v) => $q->whereDate('purchase_date', '<=', $v))
            ->orderBy('purchase_date')
            ->get();
    }

    public function getSuppliersWithDue()
    {
        return Supplier::query()
            ->whereHas('purchases', fn ($q) => $q->where('due_amount', '>', 0)->where('status', '!=', 'cancelled'))
            ->withSum(['purchases as total_due' => fn ($q) => $q->where('status', '!=', 'cancelled')], 'due_amount')
            ->orderByDesc('total_due')
            ->get();
    }
}