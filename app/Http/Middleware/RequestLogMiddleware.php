<?php

namespace App\Http\Middleware;

use App\Jobs\RequestLogJob;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // her işlemde response süresi uzamaması için kuyruğa gönderiyoruz. kuyruk ekleme yapıyor.
        // authorization header'ını hariç tutuyoruz
        try {
            RequestLogJob::dispatch([
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'body' => $request->all(),
                'headers' => collect($request->headers->all())->except('authorization')->toArray(),
                'ip_address' => $request->ip(),
            ]);
        } catch (\Throwable $e) {
        }
        return $next($request);
    }
}
