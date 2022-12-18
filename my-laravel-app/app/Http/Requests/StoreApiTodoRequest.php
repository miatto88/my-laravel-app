<?php

namespace App\Http\Requests;

use App\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreApiTodoRequest extends FormRequest
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
