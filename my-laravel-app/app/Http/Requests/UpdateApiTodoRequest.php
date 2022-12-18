<?php

namespace App\Http\Requests;

use App\User;
use App\Todo;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateApiTodoRequest extends FormRequest
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
            'title' => 'nullable | unique:todos',
            'user_id' => 'nullable | numeric'
        ];
    }

    public function withValidator($validator) {
        $validator->after(function($validator) {
            try {
                $todo = Todo::findOrFail($this->id);
                User::findOrFail($todo->user_id);
            } catch (ModelNotFoundException $e) {
                $validator->errors()->add('model', 'user does not exists');
            }
        });
    }

    protected function failedValidation($validator)
    {
        $response = response()->json([
            'status' => 'failed',
            'code' => 400,
            'errors' => $validator->errors(),
        ]);

        throw new HttpResponseException($response);
    }
}
