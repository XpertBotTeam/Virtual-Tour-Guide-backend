<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
public function handle(Request $request, Closure $next)
{
    $response = $next($request);
    $response = Response::make($response);

    $response->header('Access-Control-Allow-Origin', '*');
    $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    $response->header('Access-Control-Allow-Headers', 'Content-Type');

    // Check if OPTIONS request and add additional allowed methods
    if ($request->isMethod('OPTIONS')) {
        $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE');
    }

    return $response;
}
}
