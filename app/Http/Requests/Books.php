<?php

namespace App\Http\Requests;

use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Http\FormRequest;

class Books extends FormRequest
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
        $commonBookParams = [
            'issued_by' => 'required',
            'date' => 'bail|required|date',
        ];

        if ($this->is('guarantee/*')) {
            return $commonBookParams + [
                'title' => 'bail|required|max:30|unique:guarantee_books,title',

            ];
        } else if ($this->is('check/*')) {
            return $commonBookParams + [
                'title' => 'bail|required|max:30|unique:check_books,title',
            ];
        }
        else if ($this->is('payment/*')) {
            return $commonBookParams + [
                'title' => 'bail|required|max:30|unique:payment_and_remittance_books,title',
            ];
        }
        else if ($this->is('fguarantee/*')) {
            return $commonBookParams + [
                'title' => 'bail|required|max:30|unique:fguarantee_books,title',
            ];
        }
        else if ($this->is('fcheck/*')) {
            return $commonBookParams + [
                'title' => 'bail|required|max:30|unique:fcheck_books,title',
            ];
        }
        else if ($this->is('fpayment/*')) {
            return $commonBookParams + [
                'title' => 'bail|required|max:30|unique:fpayment_books,title',
            ];
        }

    }

    public function messages()
    {
        return [
            'issued_by.required' => 'يرجى إدخال نوع الكتاب',

            'title.required' => 'يرجى إدخال رقم الكتاب',
            'title.unique' => 'رقم الكتاب موجود بالفعل',
            'title.max' => 'تم تجاوز الحد المسموح به لعدد المحارف (30 محرف كحد أقصى)',

            'date.required' => 'يرجى إدخال التاريخ ',

        ];
    }
}
