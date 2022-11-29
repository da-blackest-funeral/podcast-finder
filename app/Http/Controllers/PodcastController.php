<?php

namespace App\Http\Controllers;

use App\DTO\CreatePodcastDTO;
use App\Events\PodcastProceeded;
use App\Http\Requests\PodcastSearchRequest;
use App\Http\Requests\UploadPodcastRequest;
use App\Models\Podcast;
use App\Services\ElasticSearch;
use App\Services\Podcast\CreatePodcastService;
use App\Services\Podcast\Processor\Processor;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;

class PodcastController extends Controller
{
    public function __construct(private Processor $processor)
    {}

    public function uploadPodcast(UploadPodcastRequest $request, CreatePodcastService $podcastService): JsonResponse
    {
        /** @var UploadedFile $file */
        $file = $request->file('file');

        $path = $file->storeAs('/', time() . $file->getClientOriginalName());

        $dto = new CreatePodcastDTO(
            path: $path,
            name: $request->name ?? $file->getClientOriginalName(),
            duration: (int) $request->duration
        );

        $podcast = $podcastService->create($dto);

        $this->processor->process($podcast);

        return new JsonResponse([
            'message' => 'Подкаст успешно загружен и обрабатывается.'
        ]);
    }

    public function index(Request $request)
    {
        return Podcast::paginate(20);
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function search(PodcastSearchRequest $request, ElasticSearch $elasticSearch)
    {
        return $elasticSearch->getBySearch($request->search);
    }
}
