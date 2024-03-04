<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class RedirectAuthenticatedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() and $request->user()->isSuperUser) return Redirect::route('admin.dashboard.view');

        if ($request->user() and $request->user()->role === 'Candidate') return Redirect::route('candidate.dashboard.view');

        if ($request->user() and in_array($request->user()->role, ['Admin', 'Manager', 'Editor'])) return Redirect::route('company.dashboard.view');

        return $next($request);
    }
}
