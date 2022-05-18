<?php

namespace App\Http\Requests;

use App\Exceptions\UserIndexValidationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class IndexUsersRequest extends FormRequest
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
            'page' => 'sometimes|required|numeric|min:1',
            'offset' => 'sometimes|required|numeric|min:0',
            'count' => 'sometimes|required|numeric|min:1|max:100',
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new UserIndexValidationException(response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'fails' => $validator->errors()], 422));
    }
}
