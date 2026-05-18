<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateApiKey
{
    public function handle(Request $request, Closure $next): Response
    {
        $key = $request->header('X-API-Key');

        if (!$key) {
            return response()->json([
                'error'   => true,
                'code'    => 'INVALID_API_KEY',
                'message' => 'Missing X-API-Key header.',
            ], 401);
        }

        $hashed = hash('sha256', $key);
        $user = User::with('plan')->where('api_key', $hashed)->first();

        if (!$user) {
            return response()->json([
                'error'   => true,
                'code'    => 'INVALID_API_KEY',
                'message' => 'Invalid API key.',
            ], 401);
        }

        $request->attributes->set('api_user', $user);

        return $next($request);
    }
}
