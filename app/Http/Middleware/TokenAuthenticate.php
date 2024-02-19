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

            if ($request->routeIs('password.reset')) $type = 'password.reset';
            else $type = 'auth.token';

            $payload = JWTHelper::verifyToken($token, $type);

            if (!$payload)
                throw new Exception();

            if (!$payload->verified and !$request->routeIs('verify') and !$request->routeIs('resend.otp'))
                throw new Exception("Please verify your account first.");

            if ($payload->verified and ($request->routeIs('verify') or $request->routeIs('resend.otp')))
                throw new Exception("Access denied.");

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
