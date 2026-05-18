<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class RateLimitApiKey
{
    /**
     * Lua script: atomically increment the counter and set expiry only on the
     * first increment of the day.  Returns the new count as an integer.
     *
     * Using a script eliminates the TOCTOU race between GET + INCR that
     * allowed bursts past the daily limit when concurrent requests raced.
     */
    private const LUA_INCR_EXPIRE = <<<'LUA'
        local n = redis.call('INCR', KEYS[1])
        if n == 1 then
            redis.call('EXPIREAT', KEYS[1], ARGV[1])
        end
        return n
        LUA;

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->attributes->get('api_user');

        if (!$user) {
            return $next($request);
        }

        $limit = $user->getDailyLimit();

        if ($limit === -1) {
            return $next($request);
        }

        $key      = 'rate_limit:' . $user->id . ':' . now()->utc()->format('Y-m-d');
        $resetAt  = now()->utc()->endOfDay()->timestamp;

        // Atomically increment; EXPIREAT is set once when the key is first created
        $used = (int) Redis::eval(self::LUA_INCR_EXPIRE, 1, $key, $resetAt);

        if ($used > $limit) {
            return response()->json([
                'error'   => true,
                'code'    => 'RATE_LIMIT_EXCEEDED',
                'message' => "Daily limit of {$limit} requests exceeded. Resets at midnight UTC.",
            ], 429)->withHeaders([
                'X-RateLimit-Limit'     => $limit,
                'X-RateLimit-Remaining' => 0,
                'X-RateLimit-Reset'     => $resetAt,
            ]);
        }

        $response = $next($request);

        return $response->withHeaders([
            'X-RateLimit-Limit'     => $limit,
            'X-RateLimit-Remaining' => max(0, $limit - $used),
            'X-RateLimit-Reset'     => $resetAt,
        ]);
    }
}
