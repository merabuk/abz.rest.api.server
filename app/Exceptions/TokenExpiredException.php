<?php

namespace App\Exceptions;

use Exception;

class TokenExpiredException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function render($request)
    {
        if ($request->wantsJson()) {
            $data['success'] = false;
            $data['message'] = 'The token expired.';

            return response()->json($data, 401);
        }
    }
}
