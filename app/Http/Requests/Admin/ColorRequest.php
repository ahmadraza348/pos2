<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ColorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $colorId = $this->route('colors')?->id;

        return [
            'name' => [
                'required', 
                'string', 
                'max:255', 
                Rule::unique('colors')->ignore($colorId)
            ],
            'slug' => [
                'required', 
                'string', 
                'max:255', 
                Rule::unique('colors')->ignore($colorId)
            ],
            'color_code' => ['required', 'string', 'max:50'],
            'status' => ['required', 'in:1,0'],
        ];
    }
}