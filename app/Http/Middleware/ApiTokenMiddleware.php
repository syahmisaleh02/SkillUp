<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('api_token')) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Your session has expired. Please log in again.');
        }

        // Verify token with Node.js backend
        try {
            $response = Http::withToken(session('api_token'))
                ->get(config('app.api_base_url') . '/auth/verify');

            if (!$response->successful()) {
                auth()->logout();
                session()->forget('api_token');
                return redirect()->route('login')->with('error', 'Your session has expired. Please log in again.');
            }
        } catch (\Exception $e) {
            // If the API is unreachable, we'll let the request continue
            // but log the error
            \Log::error('API verification failed: ' . $e->getMessage());
        }

        return $next($request);
    }
} 