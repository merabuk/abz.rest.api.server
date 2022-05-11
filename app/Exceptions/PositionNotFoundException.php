<?php

namespace App\Exceptions;

use Exception;

class PositionNotFoundException extends Exception
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
            $data['message'] = 'Positions not found';

            return response()->json($data, 422);
        }
    }
}
