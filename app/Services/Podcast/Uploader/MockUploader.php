<?php

namespace App\Services\Podcast\Uploader;

use App\DTO\UploadResponse;
use App\Models\Podcast;

class MockUploader implements PodcastUploader
{
    public function upload(Podcast $podcast): UploadResponse
    {
        return new UploadResponse('mock');
    }
}
