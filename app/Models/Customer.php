<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
    'name',
    'phone',
    'email',
    'city',
    'address',
    'opening_balance',
    'balance_type',
    'image',
    'notes',
    'status',
];


public function sales() { return $this->hasMany(Sale::class); }
}

