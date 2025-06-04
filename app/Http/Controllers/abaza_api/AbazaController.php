<?php

namespace App\Http\Controllers\abaza_api;

use App\Http\Controllers\Controller;
use App\Http\Requests\abaza_api\SendUserDataToManagerRequest;
use App\Mail\abaza_api\AbazaInternetUserData;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AbazaController extends Controller
{
    public function sendUserDataToManager(SendUserDataToManagerRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $mail = new AbazaInternetUserData($request->validated());
            Mail::send($mail);

            return response()->json([
                'success' => true,
                'message' => 'Заявка успешно отправлена менеджеру.'
            ]);
        } catch (\Throwable $e) {
            // Логируем ошибку для отладки
            Log::error('Ошибка при отправке письма: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Произошла ошибка при отправке письма.',
            ], 500);
        }
    }
}
