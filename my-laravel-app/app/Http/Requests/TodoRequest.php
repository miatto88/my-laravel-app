<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoRequest extends FormRequest
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
            'title' => 'required | unique:todos',
            'user_id' => 'required | numeric'
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'タスク名'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => ':attributeは必須です',
            'title.unique' => '同じ:attributeが既に存在しています'
        ];
    }
}
