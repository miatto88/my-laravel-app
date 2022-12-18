<?php

namespace App\Http\Requests;

use App\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateApiUserRequest extends FormRequest
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
            'name' => 'nullable | string',
            'email' => 'nullable | email',
            'password' => 'nullable | string',
            'role' => 'nullable | integer',
        ];
    }

    public function withValidator($validator) {
        $validator->after(function($validator) {
            try {
                User::findOrFail($this->id);
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
