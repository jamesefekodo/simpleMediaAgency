<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            // 0 - admin, 1-staff , 2- customer

            if (
                (int) $user->account_type == 2
            ) {
                return $next($request);
            } else {
                return redirect('/')->with('error', 'Access Denied!');
            }
        } else {
            return redirect('/')->with('error', 'Please login first!');
        }
    }
}
