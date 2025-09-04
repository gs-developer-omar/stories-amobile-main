<?php

namespace App\Services\acquiring_faq_api;

use App\DTOs\AcquiringFaqFormDTO;
use App\Mail\acquiring_faq_api\AcquiringFaqMail;
use Illuminate\Support\Facades\Mail;

class AcquiringFaqMailToAdminService
{
    public function sendMailAcquiringFaqFormData(AcquiringFaqFormDTO $acquiringFaqFormData): void
    {
        $mail = new AcquiringFaqMail($acquiringFaqFormData);
        Mail::send($mail);
    }
}