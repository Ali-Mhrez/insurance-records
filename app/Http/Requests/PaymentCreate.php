<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentCreate extends CommonRules
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return parent::rules() + [
            'number' => 'bail|required|unique:cash_payment_and_remittance_insurances',
        ];
    }

    public function messages()
    {   return parent::messages() + [
            'number.required' =>'يرجى إدخال رقم الدفعة | الحوالة',
            'number.unique' =>'رقم الدفعة | الحوالة موجود بالفعل',

    ];

    }
}
