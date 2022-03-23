<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FcheckRenew extends Books
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
        return  parent::rules()+[
            'bidder_name' => 'bail|required|string',
            'value' => 'bail|required|integer|min:0',
            'currency' => 'required',
            'equ_val_sy' => 'exclude_if:currency,ليرة سورية|bail|required|integer|min:0',
            'matter' => 'bail|required',
            'bank_name' => 'bail|required',
            'date' => 'bail|required|date',
            'status' => 'required',
            'notes' => 'bail|max:40',
            'number' => 'bail|required|unique:fchecks',
            'contract_number' => 'bail|required|integer|min:0',
            'contract_date' => 'bail|required|date',
        ];
    }

    public function messages()
    {
        return parent::messages() + [

            'bidder_name.required' => 'يرجى إدخال الاسم ',
            'bidder_name.alpha' => 'يرجى إدخال أحرف أبجدية فقط',

            'value.required' => 'يرجى إدخال قيمة التأمين',
            'value.integer' => 'يرجى إدخال قيمة صحيحة (أرقام فقط)',
            'value.min' => 'يرجى إدخال قيمة موجبة',
            'value.regex' => 'يرجى التأكد من قيمة التأمين المدخلة',

            'equ_val_sy.required' => 'يرجى إدخال القيمة',
            'equ_val_sy.integer' => 'يرجى إدخال قيمة صحيحة (أرقام فقط)',
            'equ_val_sy.min' => 'يرجى إدخال قيمة موجبة',
            'equ_val_sy.regex' => 'يرجى التأكد من قيمة التأمين المدخلة',

            'matter.required' => 'يرجى إدخال الموضوع',

            'bank_name.required' => 'يرجى اختيار اسم البنك',

            'date' => 'يرجى إدخال تاريخ صحيح',
            'date.required' => 'يرجى إدخال التاريخ ',

            'currency.required' => 'يرجى اختيار العملة',

            'status.required' => 'يرجى اختيار الحالة',

            'notes.max' => 'تم تجاوز الحد المسموح به لعدد المحارف (40 محرف كحد أقصى)',

            'number.required' => 'يرجى إدخال الرقم ',
            'number.unique' => 'الرقم  موجود بالفعل',

            'contract_number.required' => 'يرجى إدخال رقم العقد',
            'contract_number.integer' => 'يرجى إدخال أرقام فقط',
            'contract_number.min' => 'يرجى إدخال قيمة صحيحة (موجبة)',

            'contract_date.required' => 'يرجى إدخال تاريخ العقد',

        ];
    }
}
