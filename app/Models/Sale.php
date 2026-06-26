<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'invoice_no', 'customer_id', 'subtotal', 'discount', 'tax', 'grand_total',
        'paid_amount', 'due_amount', 'payment_method', 'payment_reference',
        'payment_status', 'status', 'notes', 'created_by',
    ];

    protected $casts = [
        'subtotal'    => 'decimal:2',
        'discount'    => 'decimal:2',
        'tax'         => 'decimal:2',
        'grand_total' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_amount'  => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
    public function returns()
{
    return $this->hasMany(SaleReturn::class);
}

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    // Change to give the customer (cash overpayment), never negative
    public function getChangeAttribute(): float
    {
        return max((float) $this->paid_amount - (float) $this->grand_total, 0);
    }
}