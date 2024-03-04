<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseHelper;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperUserCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()->isSuperUser)
            return ResponseHelper::make('unauthorized', null, null, [], 401);

        return $next($request);
    }
}
