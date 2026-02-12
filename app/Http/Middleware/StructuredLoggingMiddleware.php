<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class StructuredLoggingMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $requestId = (string) ($request->header('X-Request-ID') ?: Str::uuid());
        $traceId = (string) ($request->header('X-Trace-ID') ?: Str::uuid());
        $startTime = microtime(true);

        // Attach identifiers to the request for downstream usage
        $request->headers->set('X-Request-ID', $requestId);

        // Push context to log stack
        Log::shareContext([
            'request_id' => $requestId,
            'trace_id'   => $traceId,
        ]);

        Log::debug('Request started', [
            'method' => $request->method(),
            'path'   => $request->path(),
            'ip'     => $request->ip(),
        ]);

        $response = $next($request);

        $duration = round((microtime(true) - $startTime) * 1000, 2);
        $statusCode = $response->getStatusCode();

        // Add request ID to response
        $response->headers->set('X-Request-ID', $requestId);

        $logLevel = $statusCode >= 500 ? 'error' : 'debug';

        Log::log($logLevel, 'Request completed', [
            'method'      => $request->method(),
            'path'        => $request->path(),
            'status'      => $statusCode,
            'duration_ms' => $duration,
        ]);

        return $response;
    }
}
