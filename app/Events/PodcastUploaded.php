<?php

namespace App\Events;

use App\DTO\UploadResponse;
use App\Models\Podcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PodcastUploaded
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Podcast $podcast,
        public UploadResponse $responseDTO
    ) {
    }
}
