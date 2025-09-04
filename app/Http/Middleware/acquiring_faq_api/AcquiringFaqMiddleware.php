<?php

namespace App\Http\Middleware\acquiring_faq_api;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AcquiringFaqMiddleware
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
        $serverSecretKey = config('acquiring_api.secret_key', '');
        if ($routeName === 'acquiring_api.send-user-data-to-manager') {
            $phone = $params['phone'] ?? '';
            $organization = $params['organization'] ?? '';
            $data = $phone . $organization;
            return hash_hmac('sha256', $data, $serverSecretKey);
        }
        return null;
    }
}
