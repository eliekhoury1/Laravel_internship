<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class RateLimitMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();
        $key = "rate_limit:$ip";

        if (Redis::exits($key) && Redis::get($key) >= 100) {
            return response()->json(['message' => 'Too Many Requests'], Response::HTTP_TOO_MANY_REQUESTS);
        }

        Redis::incr($key);
        Redis::expire($key, 60); 

        return $next($request);
    }
}