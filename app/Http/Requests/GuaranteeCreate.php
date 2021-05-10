<?php

namespace App\Http\Requests;

use Illuminate \ Validation \ Rule;
use Illuminate\Foundation\Http\FormRequest;

class GuaranteeCreate extends CommonRules
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
            'merit_date' => 'bail|required|date|after:date',
            'number' => 'bail|required|unique:guarantees',
        ];

    }
    public function messages()
    {   return parent::messages() + [
            'number.required' =>'يرجى إدخال رقم الكفالة',
            'number.unique' =>'رقم الكفالة موجود بالفعل',

            'merit_date.required' => 'يرجى إدخال التاريخ',
            'merit_date.after' =>'يجب أن يكون تاريخ الاستحقاق تاريخاً بعد تاريخ تقديم التأمين',//
    ];

    }

}
