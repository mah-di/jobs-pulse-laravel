<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseHelper;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompanyUserCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (!$request->user()->company_id)
                throw new Exception();

            return $next($request);
        } catch (Exception $exception) {
            return ResponseHelper::make('unauthorized', null, null, [], 401);
        }
    }
}
