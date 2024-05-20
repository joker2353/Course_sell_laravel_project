<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class redirectAuthenticated
{
    public function handle($request, Closure $next, $guard = null)
    {
        $guards=empty($guards)?[null]: $guards;
        foreach($guards as $guard){
        if (Auth::guard($guard)->check()) {
            return redirect()->route('account.profile');
        }
    }
        return $next($request);
    }
}