<?php

namespace App\Http\Middleware;

use Closure;

class TokenMiddleware
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
        if (!$request->hasHeader('User-Agent') || ($request->hasHeader('User-Agent') && strpos($request->header('User-Agent'), 'fuckTimer') === false)) {
            return response()->json('Invalid User-Agent', 403);
        }

        if (!$request->bearerToken()) {
            return response()->json('No token provided', 401);
        }

        if ($request->bearerToken() == env('API_KEY')) {
            return $next($request);
        }

        return response()->json('Invalid token provided', 403);
    }
}
