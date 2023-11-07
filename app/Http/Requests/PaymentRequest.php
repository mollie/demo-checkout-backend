<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'method' => [
                'nullable',
                'max:255',
            ],
            'issuer' => [
                'nullable',
                'string',
                'max:255',
            ],

            'amount' => [
                'required',
                'regex:/^\d{1,8}(\.\d{0,2})?$/',
            ],
            'description' => [
                'required',
                'min:3',
                'max:255',
            ],
        ];
    }
}
