<?php

namespace App\Http\Requests;

use App\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreApiUserRequest extends FormRequest
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
            'name' => 'required | string',
            'email' => 'required | email',
            'password' => 'required | string',
            'role' => 'required | integer',
        ];
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
