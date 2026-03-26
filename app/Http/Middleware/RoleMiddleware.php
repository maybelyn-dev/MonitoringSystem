<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403);
        }

        if ($user->isAdmin()) {
            return $next($request);
        }

        if (!empty($roles) && !in_array($user->role, $roles, true)) {
            abort(403);
        }

        return $next($request);
    }
}
