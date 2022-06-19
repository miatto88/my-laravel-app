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

    public function messages()
    {
        return [
            'title.required' => 'タスク名は必須です',
            'title.unique' => '同じタスク名が既に存在しています'
        ];
    }
}
