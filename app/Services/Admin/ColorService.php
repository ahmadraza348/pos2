<?php

namespace App\Services\Admin;

use App\Models\Color;
use Illuminate\Support\Facades\DB;

class ColorService
{
    public function createColor(array $data)
    {
       return DB::transaction(function () use ($data) {
            $color = new Color;
            return $color->fill($data)->save();
        });

    }
    public function updateColor(Color $color, array $data)
    {
       return DB::transaction(function () use ($color, $data) {
           return $color->update($data);            
        });

    }
    public function destroyColor(Color $color)
    {
       return DB::transaction(function () use ($color) {
           return $color->delete();            
        });

    }
}
