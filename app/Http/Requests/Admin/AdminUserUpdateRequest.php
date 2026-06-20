<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminUserUpdateRequest extends FormRequest
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
  // Inside AdminUserUpdateRequest.php or ProfileUpdateRequest.php
public function rules()
{
    $id = $this->route('id') ?? auth()->guard('admin')->id();
    
    return [
        'first_name' => 'required|max:30',
        'last_name'  => 'required|max:30',
        'username'   => 'required|max:30|unique:admins,username,' . $id,
        'email'      => 'required|email|unique:admins,email,' . $id,
        'phone'      => 'nullable|max:20',
        'gender'     => 'nullable|in:male,female,other',
        'password'   => 'nullable|min:8|confirmed',
        'status'   => 'required',
        'image'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ];
}
}
