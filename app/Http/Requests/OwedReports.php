<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OwedReports extends FormRequest
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
            'record_type3' => 'bail|required',
            'report_type3' => 'bail|required',
            'owed_report'=>'array|required|min:1'
        ];
    }

    public function messages()
    {
        return  [

                'record_type3.required'=>'يرجى اختيار النوع',
                'report_type3.required'=>'يرجى اختيار النوع',
                'owed_report.*'=> 'يرجى اختيار قيمة واحدة على الأقل'
        ];
    }
}

