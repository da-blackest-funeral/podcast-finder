<?php

namespace App\Services\Podcast;

use App\DTO\CreatePodcastDTO;
use App\Models\Podcast;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class CreatePodcastService
{
    public function create(CreatePodcastDTO $dto): Podcast {
        $podcast = new Podcast;

        $podcast->user_id = Auth::id();
        $podcast->uploaded_file_name = $dto->path;
        $podcast->original_name = $dto->name;
        $podcast->duration = $dto->duration;

        $podcast->saveOrFail();

        return $podcast;
    }
}
