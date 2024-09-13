<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class RestrictSwaggerAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (config('app.env') === 'local') {
            // Разрешить доступ только с определенного IP
            if ($request->ip() !== '123.456.789.0') {
                abort(403, 'Unauthorized access');
            }
        }

        return $next($request);
    }
}
