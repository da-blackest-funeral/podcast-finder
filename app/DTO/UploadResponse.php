<?php

namespace App\DTO;

class UploadResponse
{
    public function __construct(
        public string $uploadUrl,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uploadUrl: $data['upload_url']
        );
    }
}
