<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckTokenValidity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //
        if (!$request->bearerToken()) {
            return response()->json(['message' => 'Token not provided'], 401);
        }


        if (!Auth::guard('sanctum')->check()) {
            return response()->json(['message' => 'Invalid token'], 401);
        }
        dd("tes");
        return $next($request);
    }
}
