<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // If no roles specified, allow access
        if (empty($roles)) {
            return $next($request);
        }
        
        // Check if user has one of the required roles
        if (in_array($user->role, $roles)) {
            return $next($request);
        }
        
        // Redirect based on user role
        switch ($user->role) {
            case 'admin':
                return redirect()->route('dashboard');
            case 'enseignant':
                return redirect()->route('enseignants.index');
            case 'parent':
                return redirect()->route('parents.index');
            case 'eleve':
                return redirect()->route('eleves.index');
            default:
                return redirect()->route('dashboard');
        }
    }
}