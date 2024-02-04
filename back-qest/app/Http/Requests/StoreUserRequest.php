<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|string',
            'phone' => ['required', 'regex:/^(010|011|012|015)\d{8}$/', 'unique:users'],
            'password' => 'required|min:6',
            'user_image' => 'required',
            'about' => 'required',
            'address' => 'required',
        ];
    }
}
