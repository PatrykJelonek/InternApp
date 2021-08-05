<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoggingTrace
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        \Illuminate\Support\Facades\Log::channel('traces')->info(
            $request->path(),
            [
                'client_ip' => $request->ip(),
                'full_url' => $request->fullUrl(),
                'data_dump' => $request->all(),
            ]
        );

        return $next($request);
    }
}
