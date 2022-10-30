<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function withValidator($validator) {
        $validator->after(function($validator) {
            try {
                User::findOrFail($this->user_id);
            } catch (ModelNotFoundException $e) {
                $validator->errors()->add('model', 'ユーザーが存在しません');
            }
        });
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
