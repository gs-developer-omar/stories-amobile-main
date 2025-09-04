<?php

namespace App\DTOs;

class AcquiringFaqFormDTO
{

    public function __construct(
        public string $phone,
        public string $name,
        public string $organization,
        public ?string $message = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            phone: $data['phone'],
            name: $data['name'],
            organization: $data['organization'],
            message: $data['message'] ?? null,
        );
    }
}