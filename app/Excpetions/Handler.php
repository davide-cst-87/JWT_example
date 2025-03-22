<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class Handler extends ExceptionHandler
{
    protected $dontReport = [];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->renderable(function (TokenExpiredException $e, $request) {
            return response()->json(['message' => 'Token has expired'], 401);
        });

        $this->renderable(function (TokenInvalidException $e, $request) {
            return response()->json(['message' => 'Token is invalid'], 401);
        });

        $this->renderable(function (JWTException $e, $request) {
            return response()->json(['message' => 'Token is missing or malformed'], 401);
        });
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        logger('Custom unauthenticated handler triggered');
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
}
