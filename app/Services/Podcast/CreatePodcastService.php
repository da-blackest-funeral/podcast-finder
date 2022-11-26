<?php

namespace App\Services\Podcast;

use App\Models\Podcast;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class CreatePodcastService
{
    public function create(UploadedFile $uploadedFile, string $path): Podcast
    {
        $podcast = new Podcast;
        $podcast->user_id = Auth::id();
        $podcast->uploaded_file_name = $path;
        $podcast->original_name = $uploadedFile->getClientOriginalName();

        $podcast->saveOrFail();

        return $podcast;
    }
}
