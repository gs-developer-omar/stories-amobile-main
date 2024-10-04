<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $api_key = $request->header('apiKey') ?? null;

        if (is_null($api_key)) {
            return response()->json([
                'errors' => [
                    [
                        'type' => 'FORBIDDEN',
                        'status' => Response::HTTP_FORBIDDEN,
                        'message' => 'Отсутствует параметр безопасности'
                    ]
                ],
            ], Response::HTTP_FORBIDDEN);
        }

        if ($api_key !== config('app.api_key')) {
            return response()->json([
                'errors' => [
                    [
                        'type' => 'FORBIDDEN',
                        'status' => Response::HTTP_FORBIDDEN,
                        'message' => 'Неверный параметр безопасности'
                    ]
                ],
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
