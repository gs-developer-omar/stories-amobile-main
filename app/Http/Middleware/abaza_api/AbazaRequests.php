<?php

namespace App\Http\Middleware\abaza_api;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AbazaRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $requestSignature =  $request->header('Signature');
        if (empty($requestSignature)) {
            return response()->json([
                'success' => false,
                'message' => 'Доступ запрещен'
            ], 401);
        }

        $routeName = $request->route()->getName();
        $params = $request->all();
        $expectedSignature = $this->generateExpectedSignature($routeName, $params);

        if ($expectedSignature !== $requestSignature) {
            return response()->json([
                'success' => false,
                'message' => 'Доступ запрещен'
            ], 401);
        }

        return $next($request);
    }

    protected function generateExpectedSignature($routeName, $params): ?string
    {
        $serverSecretKey = config('abaza_api.secret_key', '');
        if ($routeName === 'abaza.send-user-data-to-manager') {
            return hash_hmac('sha256', $params['phone'], $serverSecretKey);
        }
        return null;
    }
}
