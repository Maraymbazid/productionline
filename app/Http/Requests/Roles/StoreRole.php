<?php

namespace App\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;

class StoreRole extends FormRequest
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

        return  [
            'name' => 'unique:roles,name|required|max:60',
        ];
    }
    public function messages()
    {
        return  [
            'name.required' => 'لايمكن ترك اسم  الدور فارغا',
            'name.unique' => 'اسم هذا  الدور يوجد سابقا',
            'name.max'      => 'عدد الأحرف يتجاوز الحد المطلوب',

        ];
    }
}
