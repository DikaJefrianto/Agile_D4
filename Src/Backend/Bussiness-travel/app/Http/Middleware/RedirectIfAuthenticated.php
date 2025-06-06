<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard('web')->check()) {
            return redirect(RouteServiceProvider::ADMIN_DASHBOARD);
        }

        if (Auth::guard($guard)->check()) {
            return redirect(RouteServiceProvider::ADMIN_DASHBOARD);
        }

        return $next($request);
    }
}
