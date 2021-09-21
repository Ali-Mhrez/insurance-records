<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SummaryReports extends FormRequest
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
            'record_type2' => 'bail|required',
            'summary_report'=>'array|required|min:1'

        ];
    }

    public function messages()
    {
        return  [

                'record_type2.required'=>'يرجى اختيار النوع',
                'summary_report.*'=> 'يرجى اختيار قيمة واحدة على الأقل'
        ];
    }
}
