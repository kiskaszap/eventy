<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class VendorMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role->name === 'vendor') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Unauthorized Access');
    }
}

