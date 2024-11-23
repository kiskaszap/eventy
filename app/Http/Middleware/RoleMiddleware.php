<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (auth()->check() && auth()->user()->role->name === $role) {
            return $next($request);
        }

        return redirect('/'); // Redirect if unauthorized
    }
}
