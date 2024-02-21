<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class MicrosoftGraphAuthenticate
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('microsoft')->check()) {
            return $next($request);
        }
        return redirect()->route('microsoft.login');
    }
}

