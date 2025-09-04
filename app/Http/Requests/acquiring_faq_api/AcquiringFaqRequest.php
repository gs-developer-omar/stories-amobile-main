<?php

namespace App\Http\Requests\acquiring_faq_api;

use App\DTOs\AcquiringFaqFormDTO;
use Illuminate\Foundation\Http\FormRequest;

class AcquiringFaqRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone' => ['required', 'string', 'max:14'],
            'name' => ['required', 'string', 'max:255'],
            'organization' => ['required', 'string', 'max:255'],
            'message' => ['string', 'max:1000']
        ];
    }

    public function toDto(): AcquiringFaqFormDTO
    {
        return AcquiringFaqFormDTO::fromArray($this->validated());
    }
}
