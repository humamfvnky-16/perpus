<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;
use Throwable;

class AuditLog
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        try {
            if ($request->user() && !$request->isMethod('GET')) {
                ActivityLog::create([
                    'user_id'    => $request->user()->id,
                    'action'     => strtolower($request->method()) . ':' . ($request->route()?->getName() ?? $request->path()),
                    'ip_address' => $request->ip(),
                    'user_agent' => substr((string) $request->userAgent(), 0, 500),
                    'properties' => ['path' => $request->path()],
                ]);
            }
        } catch (Throwable $e) {
            // Jangan ganggu response kalau log gagal.
            logger()->warning('AuditLog gagal: ' . $e->getMessage());
        }

        return $response;
    }
}
