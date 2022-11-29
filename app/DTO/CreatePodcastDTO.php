<?php

namespace App\DTO;

use Illuminate\Http\UploadedFile;

class CreatePodcastDTO
{
    public function __construct(
        public string $path,
        public string $name,
        public int $duration
    ) {}
}
