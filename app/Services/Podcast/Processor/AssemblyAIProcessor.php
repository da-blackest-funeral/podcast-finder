<?php

namespace App\Services\Podcast\Processor;

use App\DTO\StartTranscriptionResponse;
use App\DTO\UploadResponse;
use App\Jobs\GetTranscriptionResultJob;
use App\Models\Podcast;
use App\Services\ElasticSearch;
use App\Services\Podcast\Transcriptor\MockTranscriptor;
use App\Services\Podcast\Transcriptor\Transcriptor;
use App\Services\Podcast\Uploader\MockUploader;
use App\Services\Podcast\Uploader\PodcastUploader;
use Illuminate\Support\Facades\Storage;

class AssemblyAIProcessor implements Processor
{
    private Podcast $podcast;

    public function __construct(
        private PodcastUploader $uploader,
        private Transcriptor $transcriptor,
    ) {
//        $this->uploader = new MockUploader;
//        $this->transcriptor = new MockTranscriptor;
    }

    public function process(Podcast $podcast): void
    {
        $this->podcast = $podcast;

        $uploadResponse = $this->uploader->upload($podcast);

        $this->transcript($uploadResponse);
    }

    private function transcript(UploadResponse $responseDTO): void
    {
        $data = $this->transcriptor->startTranscription($this->podcast, $responseDTO->uploadUrl);

        $delay = $this->getDelay();

        dispatch(
            new GetTranscriptionResultJob(
                $this->podcast,
                app(Transcriptor::class),
                $data->transcriptionId,
            )
        )->onQueue('podcasts')
            ->delay($delay);
    }

    private function getDelay(): int
    {
        return 150;
    }
}
