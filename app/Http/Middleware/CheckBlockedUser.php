<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CheckBlockedUser
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return RedirectResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check user auth en check if the user is blocked
        if (auth()->check() && (auth()->user()->is_active == 0)) {

            // Logout the user out and do some session thing and send the user back with a message
            auth('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors(['account_inactive' => 'Je account is inactief, neem contact op met de beheerder als je denkt dat dit een fout is.']);
        }
        return $next($request);
    }
}
