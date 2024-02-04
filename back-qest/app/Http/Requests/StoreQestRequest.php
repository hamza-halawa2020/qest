<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQestRequest extends FormRequest
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
            'client_id' => ['required', 'exists:clients,id'],
            // 'user_id' => ['required', 'exists:users,id'],
            'product_name' => 'required|string',
            'normal_price' => 'required|integer',
            'price_with_extra' => 'required|integer',
            // '1_month' => '',
            // '2_month' => '',
            // '3_month' => '',
            // '4_month' => '',
            // '5_month' => '',
            // '6_month' => '',
            // '7_month' => '',
            // '8_month' => '',
            // '9_month' => '',
            // '10_month' => '',
            // '11_month' => '',
            // '12_month' => '',
            'notes' => '',
        ];
    }
}
