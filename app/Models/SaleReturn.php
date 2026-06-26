<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleReturn extends Model
{
    use SoftDeletes;

    protected $table = 'returns';

    protected $fillable = [
        'return_no', 'sale_id', 'customer_id', 'refund_amount',
        'refund_method', 'restocked', 'reason', 'created_by',
    ];

    protected $casts = [
        'refund_amount' => 'decimal:2',
        'restocked'     => 'boolean',
    ];

    public function sale() { return $this->belongsTo(Sale::class); }
    public function customer() { return $this->belongsTo(Customer::class); }
    public function items() { return $this->hasMany(ReturnItem::class, 'return_id'); }
    public function creator() { return $this->belongsTo(Admin::class, 'created_by'); }
}