<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Resolutions extends FormRequest
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
        $RequiseBookParams = [
            'book_issued_by' => 'required',
            'book_date' => 'bail|required|date',

            'resolution_issued_by' => 'required',
            'resolution_date' => 'bail|required|date',
            'resolution_cause' => 'bail|required|string|max:40',

        ];

        if ($this->is('guarantee/*')) {
            return $RequiseBookParams + [

                'book_title' => 'bail|required|max:30|unique:guarantee_books,title',
                'resolution_title' => 'bail|required|max:30|unique:guarantee_resolutions,title',

            ];
        } else if ($this->is('check/*')) {
            return $RequiseBookParams + [
                'book_title' => 'bail|required|max:30|unique:check_books,title',
                'resolution_title' => 'bail|required|max:30|unique:check_resolutions,title',

            ];
        } else if ($this->is('payment/*')) {
            return $RequiseBookParams + [
                'book_title' => 'bail|required|max:30|unique:payment_and_remittance_books,title',
                'resolution_title' => 'bail|required|max:30|unique:payment_and_remittance_resolutions,title',

            ];
        }

        else if ($this->is('fguarantee/*')) {
            return $RequiseBookParams + [
                'book_title' => 'bail|required|max:30|unique:fguarantee_books,title',
                'resolution_title' => 'bail|required|max:30|unique:fguarantee_resolutions,title',

            ];
        }
        else if ($this->is('fcheck/*')) {
            return $RequiseBookParams + [
                'book_title' => 'bail|required|max:30|unique:fcheck_books,title',
                'resolution_title' => 'bail|required|max:30|unique:fcheck_resolutions,title',

            ];
        }
        else if ($this->is('fpayment/*')) {
            return $RequiseBookParams + [
                'book_title' => 'bail|required|max:30|unique:fpayment_books,title',
                'resolution_title' => 'bail|required|max:30|unique:fpayment_resolutions,title',

            ];
        }
    }

    public function messages()
    {
        return [
            'book_issued_by.required' => 'يرجى إدخال نوع الكتاب',

            'book_title.required' => 'يرجى إدخال رقم الكتاب',
            'book_title.unique' => 'رقم الكتاب موجود بالفعل',
            'book_title.max' => 'تم تجاوز الحد المسموح به لعدد المحارف (30 محرف كحد أقصى)',

            'book_date.required' => 'يرجى إدخال التاريخ ',

            'resolution_issued_by.required' => 'يرجى إدخال نوع الكتاب',

            'resolution_title.required' => 'يرجى إدخال رقم الكتاب',
            'resolution_title.unique' => 'رقم الكتاب موجود بالفعل',
            'resolution_title.max' => 'تم تجاوز الحد المسموح به لعدد المحارف (30 محرف كحد أقصى)',

            'resolution_date.required' => 'يرجى إدخال التاريخ ',

            'resolution_cause.required' => 'يرجى إدخال سبب المصادرة',
            'resolution_cause.max' => 'تم تجاوز الحد المسموح به لعدد المحارف (40 محرف كحد أقصى)',
        ];
    }
}
