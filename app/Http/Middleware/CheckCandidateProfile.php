<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseHelper;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCandidateProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()->candidateProfile()->exists())
            return ResponseHelper::make('fail', null, "Please save your profile informaion first");

        return $next($request);
    }
}
