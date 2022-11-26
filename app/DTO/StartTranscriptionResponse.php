<?php

namespace App\DTO;

class StartTranscriptionResponse
{
    public function __construct(public string $transcriptionId)
    {}

    public static function fromArray(array $data): StartTranscriptionResponse
    {
        return new self(
          transcriptionId: $data['id'],
        );
    }
}
