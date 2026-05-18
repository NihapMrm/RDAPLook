<?php

namespace App\Http\Middleware;

use App\Models\UsageLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogApiUsage
{
    public function handle(Request $request, Closure $next): Response
    {
        $start = microtime(true);

        $response = $next($request);

        $user = $request->attributes->get('api_user');
        if (!$user) {
            return $response;
        }

        $elapsed = (int) round((microtime(true) - $start) * 1000);
        $domain  = $request->route('domain') ?? null;
        $path    = $request->path();

        UsageLog::create([
            'user_id'          => $user->id,
            'endpoint'         => $path,
            'domain'           => $domain,
            'response_time_ms' => min($elapsed, 65535),
            'status_code'      => $response->getStatusCode(),
            'created_at'       => now(),
        ]);

        return $response;
    }
}
