<?php

namespace App\Http\Requests\Api;

use App\Exceptions\FailedValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class AbstractApiRequest extends FormRequest
{
    /**
     * Always return JSON response, because if client not use "Accept: application/json" header - default response is redirect to home page
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator) {
        $response  = new JsonResponse([
            'success' => false,
            'message' => 'Validation failed',
            'fails' => $validator->errors()
        ], 422);
        throw new FailedValidationException($response);
    }
}
