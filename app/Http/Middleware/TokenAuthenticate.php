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
            if (!$request->user())
                throw new Exception();

            $payload = json_decode($request->header('payloadData'));

            if (!$payload)
                throw new Exception();

            if (!$payload->verified and !$request->routeIs('verify.view') and !$request->routeIs('verify.email') and !$request->routeIs('resend.otp'))
                throw new Exception("Please verify your account first.");

            if ($payload->verified and ($request->routeIs('verify.view') or $request->routeIs('verify.email') or $request->routeIs('resend.otp')))
                throw new Exception("Access denied.");

            return $next($request);

        } catch (Exception $exception) {
            return ResponseHelper::make('unauthorized', null, $exception->getMessage(), [], 401);
        }
    }
}
