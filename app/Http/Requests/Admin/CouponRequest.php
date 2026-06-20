<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
 public function rules(): array
{
    // Match the name used in the route: {coupon}
    $couponId = $this->route('coupon') instanceof \App\Models\Coupon 
        ? $this->route('coupon')->id 
        : $this->route('coupon');

    return [
        'label' => 'required|string',
        'discount_type' => 'required',
        'amount' => 'required|numeric',
        // Now the ignore() will properly skip the current record
        'code' => ['required', 'string', Rule::unique('coupons', 'code')->ignore($couponId)],
        'starting_from' => 'required|date',
        'ending_at' => 'required|date',
        'status' => 'required|string',
    ];
}
}
