<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'email',
        'name',
        'company_name',
        'phone',
        'address',
        'status',
        'opening_balance'
    ];   
public function purchases() { return $this->hasMany(Purchase::class); }

 
}
