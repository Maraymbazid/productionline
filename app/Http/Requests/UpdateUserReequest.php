<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserReequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'     => [
                'required','string','max:200'
            ],
            'email'    => [
                'required',
                'email',
            ],
            'password' => [
                'same:confirm-password',
            ],
            'roles'    => [
                'required',
                'array',
            ],
        ];
    }
    public function messages()
    {
        return  [
            'name.required' => 'لايمكن ترك  الاسم فارغا',
            'email.required' => 'لايمكن ترك  الايميل فارغا',
            'password.same' => 'لايوجد تطابق بين كلمة السر و تأكيد كلمة السر',
            'roles.required' => 'اختار الدور المناسب',
            'string' => 'اختار صيغة صحيحة',
            'max'      => 'عدد الأحرف يتجاوز الحد المطلوب',
            'email.unique'=>'هذا الايميل يوجد سابقا',

        ];
    }
}
