<?php

namespace App\Http\Requests;

//use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Request ;
use Illuminate\Foundation\Http\FormRequest;


class CommonRules extends FormRequest
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
     //Request $request;
        $commonParams = [
            'bidder_name' => 'bail|required|max:40|string',
            'value' => 'bail|required|integer|min:0',
            'currency' => 'required',
            'equ_val_sy' => 'exclude_if:currency,ليرة سورية|required|integer|min:0',
            'matter' => 'bail|required|max:30',
            'bank_id' => 'exclude_if:type,دفعة نقدية|required',
            'date' => 'bail|required|date',
            'status' => 'required',
            'notes' => 'bail|max:40',
        ];
        if (Request::has('type')) {
            return   $commonParams + ['type' => 'required',];
        } else {
            return
           $commonParams ;
        }
    }
    public function messages()
    {
        return [

            'bidder_name.required' => 'يرجى إدخال الاسم ',
            'bidder_name.max' => 'تم تجاوز الحد المسموح به لعدد المحارف (40 محرف كحد أقصى)',
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
            'matter.max' => 'تم تجاوز الحد المسموح به لعدد المحارف (30 محرف كحد أقصى)',

            'bank_id.required' => 'يرجى اختيار اسم البنك',

            'number.required' => 'يرجى إدخال الرقم ',
            'number.unique' => 'الرقم  موجود بالفعل',

            'date' => 'يرجى إدخال تاريخ صحيح',
            'date.required' => 'يرجى إدخال التاريخ ',

            'currency.required' => 'يرجى اختيار العملة',

            'type.required' => 'يرجى اختيار النوع',

            'status.required' => 'يرجى اختيار الحالة',

            'notes.max' => 'تم تجاوز الحد المسموح به لعدد المحارف (40 محرف كحد أقصى)',

        ];
    }
}
