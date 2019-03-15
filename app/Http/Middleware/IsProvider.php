<?php

namespace App\Http\Middleware;

use App\Services\Response\ApiResponse;
use Closure;

class IsProvider
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $request->user()->authorizeRoles('provider')) {
            $response = new ApiResponse(-3, 'You must be a provider to complete this task', [], 401);

            return $response->toJson();
        }

        return $next($request);
    }
}
