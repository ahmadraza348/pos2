<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Order::select(
            'order_number',
            'billing_first_name',
            'billing_last_name',
            'billing_phone',
            'total_amount',
            'payment_method',
            'payment_status',
            'order_status',
            'created_at'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Order #',
            'First Name',
            'Last Name',
            'Phone',
            'Total',
            'Payment Method',
            'Payment Status',
            'Order Status',
            'Date',
        ];
    }
}
