<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     * 
     * This middleware verifies that the user is authenticated and has the 'admin' role.
     * If the user is not authenticated or does not have the admin role, they will be 
     * redirected to a 403 Forbidden error page.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect('login');
        }
        
        // Check if the authenticated user has the admin role
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action. This action requires admin privileges.');
        }
        
        // User is authenticated and is an admin, proceed with the request
        return $next($request);
    }
}
