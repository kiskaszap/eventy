<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        if (Auth::check() && Auth::user()->role->name === $role) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Unauthorized Access');
    }
}
