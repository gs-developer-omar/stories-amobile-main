<?php

namespace App\Http\Controllers\acquiring_faq_api;

use App\Http\Controllers\Controller;
use App\Http\Requests\acquiring_faq_api\AcquiringFaqRequest;
use App\Services\acquiring_faq_api\AcquiringFaqMailToAdminService;
use Illuminate\Http\JsonResponse;

class AcquiringFaqController extends Controller
{
    public function __construct(
        protected AcquiringFaqMailToAdminService $mailToAdminService
    ) {}

    public function __invoke(AcquiringFaqRequest $request): JsonResponse
    {
        $acquiringFaqData = $request->toDto();

        try {
            $this->mailToAdminService->sendMailAcquiringFaqFormData($acquiringFaqData);

            return response()->json([
                'success' => true,
                'message' => 'Письмо успешно отправлено',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при отправке письма: ' . $e->getMessage(),
            ], 500);
        }
    }
}
