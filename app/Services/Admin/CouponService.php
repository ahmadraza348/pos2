<?php

namespace App\Services\Admin;

use App\Models\Coupon;
use Illuminate\Support\Facades\DB;
use Exception;

class CouponService
{
    /**
     * Create a new coupon.
     */
    public function create(array $data): Coupon
    {
        return DB::transaction(function () use ($data) {
            return Coupon::create($data);
        });
    }

    /**
     * Update an existing coupon.
     */
    public function update(Coupon $coupon, array $data): Coupon
    {
        return DB::transaction(function () use ($coupon, $data) {
            $coupon->update($data);
            return $coupon;
        });
    }

    /**
     * Delete a coupon.
     */
    public function delete(Coupon $coupon): bool
    {
        return DB::transaction(function () use ($coupon) {
            return $coupon->delete();
        });
    }
}