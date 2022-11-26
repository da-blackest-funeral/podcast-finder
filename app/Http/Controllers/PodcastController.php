<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadPodcastRequest;
use App\Models\Podcast;
use App\Services\Podcast\CreatePodcastService;
use App\Services\Podcast\Processor\Processor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PodcastController extends Controller
{
    public function __construct(private Processor $processor)
    {
    }

    public function uploadPodcast(UploadPodcastRequest $request, CreatePodcastService $podcastService)
    {
//        $file = file_get_contents('../storage/app/podcasts/bvKcUylEaWGQN1qaw0TDxIq1ofhIz0R0tbbvPeFl.mp3');
//        $podcast = Podcast::first();
//        $podcast->uploaded_file_name = 'bvKcUylEaWGQN1qaw0TDxIq1ofhIz0R0tbbvPeFl.mp3';
//        $podcast->save();

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
