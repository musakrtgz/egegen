<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class BearerTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        $bearerToken = $request->bearerToken();
        $maxAttempts = 3; // Maksimum deneme sayısı

        // token boş ise veya geçersiz ise
        if (!$bearerToken || $bearerToken !== config('auth.bearer_token')) {
            $executed = RateLimiter::attempt(
                'unauthorized:' . $ip,
                $maxAttempts,
                function () {},
                decaySeconds: 120 // 10 dakika boyunca geçerli
            );

            if (!$executed) {
                return response()->json(['message' => 'Too Many Unauthorized Requests'], 429);
            }

            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // ip blokta ise geçerli token olsa bile erişim reddedilir
        if (!RateLimiter::remaining('unauthorized:' . $ip, $maxAttempts)) {
            return response()->json(['message' => 'Too Many Unauthorized Requests'], 429);
        }

        return $next($request);
    }
}
