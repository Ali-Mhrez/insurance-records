<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuaranteeExtend extends Books
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
        return parent::rules() +  [
            'new_merit' => 'bail|required|date|after:date',
        ];
    }

    public function messages()
    {
        return parent::messages() + [

            'new_merit.required' => 'يرجى إدخال التاريخ',//
            'new_merit.after' =>'يجب أن يكون تاريخ الاستحقاق تاريخاً بعد تاريخ تقديم التأمين',
        ];
    }
}
