<?php

namespace App\Http\Middleware;

use App\Models\VisitorLog;
use Closure;
use Illuminate\Http\Request;
use Throwable;

class TrackVisitor
{
    protected array $except = ['up', 'favicon.ico', 'robots.txt'];

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        try {
            if ($request->isMethod('GET') && !$request->ajax() && !$request->wantsJson() && !$request->is($this->except)) {
                VisitorLog::create([
                    'user_id'    => $request->user()?->id,
                    'path'       => '/' . ltrim($request->path(), '/'),
                    'method'     => $request->method(),
                    'ip_address' => $request->ip(),
                    'user_agent' => substr((string) $request->userAgent(), 0, 500),
                    'referer'    => substr((string) $request->headers->get('referer'), 0, 500),
                ]);
            }
        } catch (Throwable $e) {
            logger()->warning('TrackVisitor gagal: ' . $e->getMessage());
        }

        return $response;
    }
}
