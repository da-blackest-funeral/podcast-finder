<?php

namespace App\DTO;

class TranscriptionResult
{
    public function __construct(
        public string $text,
    ) {}

    public static function fromArray(array $data)
    {
        return new self(
            text: $data['text'],
        );
    }
}
