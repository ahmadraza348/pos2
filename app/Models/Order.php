<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'session_id',
        'billing_first_name',
        'billing_last_name',
        'billing_email',
        'billing_company',
        'billing_country',
        'billing_address_1',
        'billing_address_2',
        'billing_city',
        'billing_state',
        'billing_postcode',
        'billing_phone',
        'different_shipping',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_email',
        'shipping_company',
        'shipping_country',
        'shipping_address_1',
        'shipping_address_2',
        'shipping_city',
        'shipping_state',
        'shipping_postcode',
        'subtotal',
        'shipping_charge',
        'discount',
        'total_amount',
        'order_note',
        'payment_method',
        'payment_status',
        'order_status',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($order) {
            $order->order_number = 'ORD-' . strtoupper(uniqid());
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Helper method to get full name
    public function getBillingFullNameAttribute()
    {
        return $this->billing_first_name . ' ' . $this->billing_last_name;
    }

    public function getShippingFullNameAttribute()
    {
        if ($this->different_shipping) {
            return $this->shipping_first_name . ' ' . $this->shipping_last_name;
        }
        return $this->billing_first_name . ' ' . $this->billing_last_name;
    }

    // Status scopes
    public function scopePending($query)
    {
        return $query->where('order_status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('order_status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('order_status', 'cancelled');
    }
}