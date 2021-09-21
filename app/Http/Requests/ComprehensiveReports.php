<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComprehensiveReports extends FormRequest
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
            'report_type4' => 'bail|required',
            'comprehensive_report'=>'array|required|min:1'
        ];
    }

    public function messages()
    {
        return  [

                'report_type4.required'=>'يرجى اختيار النوع',
                'comprehensive_report.*'=> 'يرجى اختيار قيمة واحدة على الأقل'
        ];
    }
}
