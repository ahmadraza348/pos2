<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['name'];

    // mutator for name to ensure it is stored in lowercase
    public function setNameAttribute($value)
    {        $this->attributes['name'] = strtolower($value);
    }

}
