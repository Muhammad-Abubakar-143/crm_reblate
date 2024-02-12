<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::check()) {
            return redirect('/login');
        }
        if (Auth::check() && Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'client' || Auth::user()->user_type == 'employee') {
            return $next($request);
        }
        return redirect('/');
    }
}
