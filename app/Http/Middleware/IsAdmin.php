<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if(auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }
        
        return redirect()->route('employee.dashboard')->with('error', 'Access denied. You must be an admin to access this area.');
    }
} 