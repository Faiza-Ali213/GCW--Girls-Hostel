<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    /**
     * Handle an incoming request.
     * Only allows users with the "admin" role.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Only admins may pass
        if ($user->isAdmin()) {
            return $next($request);
        }

        // If they are a clerk, send them to their own home page
        if ($user->isClerk()) {
            return redirect()->route('fee_record')
                ->with('error', 'You do not have permission to access that page.');
        }

        // Unknown role — log out
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('error', 'Unauthorized access.');
    }
}