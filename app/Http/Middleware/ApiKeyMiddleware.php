<?php

namespace App\Http\Middleware;

use Closure;

class ApiKeyMiddleware
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
        // Pre-Middleware Action
        $key = $request->header('api-key');
        if($key !== env('API_KEY')){
            return response('Unauthorized.', 401);
        }
        // Post-Middleware Action

        return $next($request);
    }
}
