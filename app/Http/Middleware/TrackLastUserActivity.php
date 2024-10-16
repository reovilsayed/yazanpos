<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TrackLastUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            

            if ($user->last_activity && now()->diffInMinutes($user->last_activity) >= 60) {
                Auth::logout(); // Log the user out
                $request->session()->invalidate(); // Invalidate the session
                $request->session()->regenerateToken(); // Regenerate CSRF token

                return redirect('/login')->withErrors(['You have been logged out due to inactivity.']);
            }
            $user->last_activity = now();
            $user->save();
        }

        return $next($request);
    }
}
