<?php

namespace App\Exceptions;

use Exception;

class UserNotFoundException extends Exception
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
            $data['message'] = 'The user with the requested identifier does not exist';
            $data['fails']['user_id'] = ['User not found'];

            return response()->json($data, 404);
        }
    }
}
