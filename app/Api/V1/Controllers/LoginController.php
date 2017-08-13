<?php

namespace App\Api\V1\Controllers;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\LoginRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class LoginController extends Controller
{
    public function login(LoginRequest $request, JWTAuth $JWTAuth)
    {
        $credentials = $request->only(['email', 'password']);

        try {
            $token = $JWTAuth->attempt($credentials);
            if (! $token ) {
                return response()->json([
                    'message' => 'Wrong Email or Password'
                ], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json([
              'message' => 'Could not verify User'
            ], 500);
        }

        return response()->json([
            'message' => 'ok',
            'token' => $token
        ]);
    }
}
