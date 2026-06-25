<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforceRole
{
    /**
     * Handle an incoming request.
     *
     * We intercept the request pipeline and evaluate if the authenticated user 
     * possesses the precise role required to pass the route boundary.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Verify user authentication status
        if (!$request->user()) {
            return $request->expectsJson()
                ? response()->json(['status' => 'UNAUTHENTICATED', 'message' => 'Authentication required.'], 401)
                : redirect()->route('login');
        }

        // 2. Validate current role matches boundary parameters
        // Ongoing system execution requires strict identity matching
        if (!in_array($request->user()->role, $roles)) {
            return $request->expectsJson()
                ? response()->json([
                    'status'  => 'UNAUTHORIZED_ACCESS',
                    'message' => 'Access Denied: Your security profile does not match this module boundary.'
                ], 403)
                : abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}