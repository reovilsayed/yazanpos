<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $secretKey = 'pos_password';
        if ($request->header('x-secret-key') !== $secretKey) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}
