<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadPodcastRequest;
use App\Models\Podcast;
use App\Services\Podcast\CreatePodcastService;
use App\Services\Podcast\Processor\Processor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;

class PodcastController extends Controller
{
    public function __construct(private Processor $processor)
    {}

    public function uploadPodcast(UploadPodcastRequest $request, CreatePodcastService $podcastService): JsonResponse
    {
        /** @var UploadedFile $file */
        $file = $request->file('file');

        $path = $file->storeAs('/', time() . $file->getClientOriginalName());

        $podcast = $podcastService->create($file, $path);

        $this->processor->process($podcast);

        return new JsonResponse([
            'message' => 'Подкаст успешно загружен и обрабатывается.'
        ]);
    }
}
