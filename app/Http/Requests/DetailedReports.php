<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetailedReports extends FormRequest
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
        return [
            'record_type1' => 'bail|required',
            'report_type1' => 'bail|required',
            'from' => 'bail|required|date',
            'to' => 'bail|required|date|after:from',
            'detailed_report'=>'array|required|min:1'
        ];
    }

    public function messages()
    {
        return  [

                'record_type1.required'=>'يرجى اختيار النوع',
                'report_type1.required'=>'يرجى اختيار النوع',
                'from.required' => 'يرجى إدخال التاريخ',
                'to.required' => 'يرجى إدخال التاريخ',
                'to.after' =>'يرجى إدخال قيمة صحيحة',
                'detailed_report.*'=> 'يرجى اختيار قيمة واحدة على الأقل'
        ];
    }
}
