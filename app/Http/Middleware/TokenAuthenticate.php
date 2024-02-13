<?php

namespace App\Http\Middleware;

use App\Helpers\JWTHelper;
use App\Helpers\ResponseHelper;
use App\Models\User;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TokenAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $token = $request->header('token') ?? $request->cookie('token');

            $payload = JWTHelper::verifyToken($token);

            $user = User::find($payload->userID);

            if (!$user)
                throw new Exception();

            Auth::setUser($user);

            return $next($request);

        } catch (Exception $exception) {
            return ResponseHelper::make('unauthorized', null, $exception->getMessage(), [], 401);
        }
    }
}
