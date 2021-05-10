<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBanks extends FormRequest
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
            'name' => 'bail|required|unique:banks|max:30',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'يرجى إدخال اسم البنك',
            'name.unique' => 'هذا الاسم موجود بالفعل',
            'name.max' => 'الحد الأقصى لاسم البنك 30 محرف',
        ];
    }
}
