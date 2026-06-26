<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'expense_no', 'expense_category_id', 'expense_date', 'amount',
        'payment_method', 'payment_reference', 'title', 'description',
        'attachment', 'created_by',
    ];

    protected $casts = [
        'expense_date' => 'date',
        'amount'       => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function scopeBetweenDates($query, $from, $to)
    {
        return $query->whereDate('expense_date', '>=', $from)->whereDate('expense_date', '<=', $to);
    }
}