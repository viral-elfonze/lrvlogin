<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->header('Access-Control-Allow-Origin', '*');
        $response->header('Access-Control-Allow-Origin', ['*', 'http://localhost:3000/']);
        $response->header('Access-Control-Allow-Methods', ['GET', 'POST', 'PUT', 'PATCH', 'DELETE']);
        $response->header('Access-Control-Allow-Credentials', true);
        $response->header('Access-Control-Allow-Headers', ' Origin, Content-Type, Accept, Authorization, X-Request-With');
        $response->header('Access-Control-Allow-Credentials', ' true');

        // Handle preflight OPTIONS request
        if ($request->isMethod('OPTIONS')) {
            $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE');
            $response->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Accept, Authorization, X-Requested-With');
            return $response;
        }

        return $response;
    }
}
