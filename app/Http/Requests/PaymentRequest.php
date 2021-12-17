<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'method' => [
                'max:255',
            ],
            'issuer' => [
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
