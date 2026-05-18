<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RapidApiMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $secret = env('RAPIDAPI_PROXY_SECRET');

        // Skip check in local dev when secret is not configured
        if (!empty($secret)) {
            $header = $request->header('X-RapidAPI-Proxy-Secret');

            if (!$header || !hash_equals($secret, $header)) {
                return response()->json([
                    'error'   => true,
                    'code'    => 'FORBIDDEN',
                    'message' => 'Access via RapidAPI only.',
                ], 403);
            }
        }

        return $next($request);
    }
}
