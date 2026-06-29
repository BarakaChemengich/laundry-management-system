<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforceRole
{
    /**
     * Handle an incoming request.
     * Intercepts the request pipeline and evaluates if the authenticated user
     * possesses the precise role required to pass the route boundary.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Verify user authentication status
        if (!$request->user()) {
            return $request->expectsJson()
                ? response()->json(['status' => 'UNAUTHENTICATED', 'message' => 'Authentication required.'], 401)
                : redirect()->route('login');
        }

        // 2. Get user's role name from relationship
        $userRole = $request->user()->role?->name ?? '';

        // 3. Validate current role matches boundary parameters
        if (!in_array($userRole, $roles)) {
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