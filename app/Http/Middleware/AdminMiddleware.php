<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Please login to access admin panel.');
        }
        
        $user = Auth::user();
        
        // Simple direct check for role
        if (isset($user->role) && $user->role === 'admin') {
            return $next($request);
        }
        
        // Check if user has is_admin property
        if (isset($user->is_admin) && $user->is_admin == 1) {
            return $next($request);
        }
        
        Auth::logout();
        return redirect()->route('admin.login')->with('error', 'You do not have admin access.');
    }
}