<?php

namespace App\Http\Requests\Permission;

use Illuminate\Foundation\Http\FormRequest;

class StorePermission extends FormRequest
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
            'name' => 'unique:permissions,name|required|max:60',
        ];
    }
    public function messages()
    {
        return  [
            'name.required' => 'لايمكن ترك اسم الصلاحية فارغا',
            'name.unique' => 'اسم هذه الصلاحية يوجد سابقا',
            'name.max'      => 'عدد الأحرف يتجاوز الحد المطلوب',

        ];
    }
}
