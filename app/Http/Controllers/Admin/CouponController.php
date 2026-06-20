<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CouponRequest;
use App\Models\Coupon;
use App\Services\Admin\CouponService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    protected $service;

    public function __construct(CouponService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $data['coupons'] = Coupon::latest()->get();
        return view('backend.coupons.coupons', $data);
    }

    public function store(CouponRequest $request)
    {
        $this->service->create($request->validated());
        toastr()->success('Coupon created successfully.');
        return redirect()->route('coupons.index');
    }

    public function edit(Coupon $coupon)
    {
        // We pass the same view as index, but with the specific coupon for editing
        return view('backend.coupons.coupons', [
            'coupons' => Coupon::latest()->get(),
            'editingCoupon' => $coupon,
        ]);
    }

    public function update(CouponRequest $request, Coupon $coupon)
    {
        // Fixed: changed validate() to validated()
        $this->service->update($coupon, $request->validated());
        
        toastr()->success('Coupon updated successfully.');
        
        // Redirecting to index clears the edit form and the URL ID
        return redirect()->route('coupons.index');
    }

    public function destroy(Coupon $coupon)
    {
        $this->service->delete($coupon);
        toastr()->success('Coupon deleted successfully.');
        return redirect()->route('coupons.index');
    }
}