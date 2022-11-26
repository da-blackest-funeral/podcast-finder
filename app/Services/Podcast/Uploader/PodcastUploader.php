<?php

namespace App\Services\Podcast\Uploader;

// todo AssemblyAIUploader
use App\DTO\UploadResponse;
use App\Models\Podcast;

interface PodcastUploader
{
    public function upload(Podcast $podcast): UploadResponse;
}
