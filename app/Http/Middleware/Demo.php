<?php

namespace App\Http\Middleware;

use Closure;
use Inertia\Inertia;

class Demo
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
        if (config('app.demo_mode') == true) {
            return Inertia::render('Auth/Demo');
        }

        return $next($request);
    }
}
