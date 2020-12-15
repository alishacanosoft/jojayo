<?php

namespace App\Http\Middleware;

use Closure;

class Customer
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
        if ($request->user()->roles == 'customers'){
            return $next($request);
        } else {
            return $next($request);
            return redirect('auth/dashboard');
        }
    }
}
