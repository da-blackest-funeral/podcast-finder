<?php

namespace App\Services\Podcast\Processor;

use App\DTO\StartTranscriptionResponse;
use App\DTO\UploadResponse;
use App\Events\PodcastUploaded;
use App\Jobs\GetTranscriptionResultJob;
use App\Jobs\UploadToAssemblyAIJob;
use App\Models\Podcast;
use App\Services\ElasticSearch;
use App\Services\Podcast\Transcriptor\MockTranscriptor;
use App\Services\Podcast\Transcriptor\Transcriptor;
use App\Services\Podcast\Uploader\MockUploader;
use App\Services\Podcast\Uploader\PodcastUploader;
use Illuminate\Support\Facades\Storage;

class AssemblyAIProcessor implements Processor
{
    public function __construct(
        private PodcastUploader $uploader,
        private Transcriptor $transcriptor,
    ) {
    }

    public function process(Podcast $podcast): void
    {
        dispatch(new UploadToAssemblyAIJob(
            $this->uploader,
            $podcast
        ))->onQueue('podcasts');
    }

    public function transcript(PodcastUploaded $event): void
    {
        $responseDTO = $event->responseDTO;
        $podcast = $event->podcast;

        $data = $this->transcriptor->startTranscription($podcast, $responseDTO->uploadUrl);

        $delay = $this->getDelay($podcast);

        dispatch(
            new GetTranscriptionResultJob(
                $podcast,
                app(Transcriptor::class),
                $data->transcriptionId,
            )
        )->onQueue('podcasts')
            ->delay($delay);
    }

    private function getDelay(Podcast $podcast): int
    {
        return (int) ($podcast->duration / 2);
    }
}
