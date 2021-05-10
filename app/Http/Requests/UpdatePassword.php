<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePassword extends FormRequest
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

        return  [
            'password' => 'required',
            'newPassword' => 'required|string|min:6|different:password',
            'confirmedPassword' => 'required|same:newPassword',
        ];

    }
    public function messages()
    {   return [
            'password.required' =>'يرجى إدخال كلمة المرور الحالية',

            'newPassword.required' => 'يرجى إدخال كلمة المرور الجديدة',
            'newPassword.min' => 'كلمة المرور يجب أن تكون 6 محارف على الأقل',
            'newPassword.different' => 'كلمة المرور الجديدة لايمكن أن تكون مشابهة مع الحالية، يرجى اختيار كلمة مرور أخرى',

            'confirmedPassword.required' =>'يرجى تأكيد كلمة المرور الجديدة',
            'confirmedPassword.same' =>'تأكيد كلمة المرور الجديدة غير متطابق',
            
        ];

    }
}
