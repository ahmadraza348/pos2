<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'invoice_no',
        'supplier_id',
        'purchase_date',
        'subtotal',
        'discount',
        'tax',
        'total_amount',
        'paid_amount',
        'due_amount',
        'payment_status',
        'status',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'subtotal'      => 'decimal:2',
        'discount'      => 'decimal:2',
        'tax'           => 'decimal:2',
        'total_amount'  => 'decimal:2',
        'paid_amount'   => 'decimal:2',
        'due_amount'    => 'decimal:2',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function creator()
    {
        // created_by references the admins table (see migration), not users.
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeReceived($query)
    {
        return $query->where('status', 'received');
    }

    /**
     * A purchase's items are locked once it's "received" or "cancelled".
     * Once received, its items have already moved real stock and blended
     * into the product's weighted-average cost — editing them after the
     * fact can't be done reliably (see PurchaseService), so a received
     * purchase is view-only from here on. The only remaining action is
     * cancelling it, which PurchaseService reverses in a controlled way.
     */
    public function getItemsLockedAttribute(): bool
    {
        return in_array($this->status, ['received', 'cancelled'], true);
    }
}