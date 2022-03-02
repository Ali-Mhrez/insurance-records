<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FpaymentCreate extends CommonRules
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
            'number' => 'bail|required||unique:fpayments',
            'contract_number' => 'bail|required|integer|min:0',
            'contract_date' => 'bail|required|date',

        ];
    }

    public function messages()
    {   return parent::messages() + [

            'number.required' =>'يرجى إدخال الرقم ',
            'number.unique' =>'الرقم موجود بالفعل',

            'contract_number.required' => 'يرجى إدخال رقم العقد',
            'contract_number.integer' => 'يرجى إدخال أرقام فقط',
            'contract_number.min' => 'يرجى إدخال قيمة صحيحة (موجبة)',

            'contract_date.required' => 'يرجى إدخال تاريخ العقد',
    ];

    }
}
