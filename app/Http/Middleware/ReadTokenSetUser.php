<?php

namespace App\Http\Middleware;

use App\Helpers\JWTHelper;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ReadTokenSetUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('token') ?? $request->cookie('token');

        if ($request->routeIs('password.reset') or $request->routeIs('password.reset.view')) $type = 'password.reset';
        else $type = 'auth.token';

        $payload = JWTHelper::verifyToken($token, $type);

        if ($payload) {
            $user = User::find($payload->userID);

            if ($user) Auth::setUser($user);
        }

        $request->headers->set('payloadData', json_encode($payload));

        return $next($request);
    }
}
