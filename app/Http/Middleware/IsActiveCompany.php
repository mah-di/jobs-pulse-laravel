<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseHelper;
use App\Models\Company;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsActiveCompany
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if ($request->user()->company_id and $request->user()->company->status !== 'ACTIVE')
                throw new Exception("Access denied!");

            if (in_array($request->user()->role, ['Manager', 'Editor']) and !$request->user()->company->companyPlugins()->where(['plugin_id' => Company::EMPLOYEE, 'status' => 'ACTIVE'])->exists())
                throw new Exception("Access denied!");

            return $next($request);

        } catch (Exception $exception) {
            return ResponseHelper::make('unauthorized', null, $exception->getMessage(), [], 401);
        }
    }
}
