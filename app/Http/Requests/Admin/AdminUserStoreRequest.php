<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminUserStoreRequest extends FormRequest
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
        return [
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'username' => 'required|unique:admins|max:30',
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
            'status'   => 'required',
            'role' => 'required|exists:roles,id',
        ];
    }
}
