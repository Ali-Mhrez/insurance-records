<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewUser extends FormRequest
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
            'name' => 'required|max:30',
            'permissions' => 'required'
        ];
    }

    public function messages()
    {   return [
            'name.required' =>'يرجى إدخال اسم المستخدم',
            'name.regex' => 'تنسيق الاسم غير صحيح ',
            'name.max' => 'الحد الأقصى لعدد المحارف 30 محرف فقط',
            'permissions.required' =>'لم يتم تحديد السماحيات !'
        ];

    }
}
