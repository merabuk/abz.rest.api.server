<?php

namespace App\Http\Controllers\Api;

class AuthController extends ApiController
{
    public function login()
    {
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        $credentials = [
            'email' => $email,
            'password' => $password
        ];

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'success' => true,
            'token' => $token,
        ], 200);
    }
}
