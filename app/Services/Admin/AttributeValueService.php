<?php

namespace App\Services\Admin;

use App\Models\AttributeValue;
use Illuminate\Support\Facades\DB;



class AttributeValueService
{
    public function create(array $data): AttributeValue
    {
        return DB::transaction(fn() => AttributeValue::create($data));
    }

    public function update(AttributeValue $value, array $data): AttributeValue
    {
        return DB::transaction(function () use ($value, $data) {
            $value->update($data);
            $value->save();
            return $value;
        });
    }
    public function destroy(AttributeValue $attributeValue): bool
    {
        return DB::transaction(fn() => $attributeValue->delete());
    }
}
