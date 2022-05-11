<?php

namespace App\Exceptions;

use Exception;

class UserValidateRouteParameterException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        if ($request->wantsJson()) {
            $data['success'] = false;
            $data['message'] = 'Validation failed';
            $data['fails']['user_id'] = ['The user_id must be an integer.'];

            return response()->json($data, 400);
        }
    }
}
