<?php

namespace App\Exceptions;

use Exception;

class UserQueryException extends Exception
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
            $data['message'] = 'User with this phone or email already exist';

            return response()->json($data, 409);
        }
    }
}
