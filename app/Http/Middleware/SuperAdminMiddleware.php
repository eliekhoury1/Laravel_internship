<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         // Check if the user has the 'super-admin' role
         if ($request->user() && $request->user()->hasRole('super-admin')) {
            return $next($request);
        }

        // If not, deny access
        abort(403, 'Unauthorized action.');

    }
}
