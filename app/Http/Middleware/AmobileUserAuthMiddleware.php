<?php

namespace App\Http\Middleware;

use App\Enums\api\v1\ERROR_TYPE;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AmobileUserAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $phone = $request->input('phone');

        if (is_null($phone)) {
            return response()->json([
                'errors' => [
                    [
                        'type' => 'UNAUTHORIZED',
                        'status' => Response::HTTP_UNAUTHORIZED,
                        'message' => 'Поле phone обязательно'
                    ]
                ],
            ], Response::HTTP_UNAUTHORIZED);
        }

        try {
            $request->validate([
                'phone' => 'required|string|min:7|max:16|regex:/^[\+\d\- \(\)]+$/'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => array_map(function ($error) {
                    return [
                        'type' => ERROR_TYPE::HTTP_UNPROCESSABLE_ENTITY,
                        'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                        'message' => rtrim($error, '.')
                    ];
                }, $e->errors()['phone'])
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $next($request);
    }
}
