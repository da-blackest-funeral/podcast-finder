<?php

namespace App\Jobs;

use App\Events\PodcastProceeded;
use App\Models\Podcast;
use App\Services\ElasticSearch;
use App\Services\Podcast\Transcriptor\Transcriptor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetTranscriptionResultJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(
        private Podcast $podcast,
        private Transcriptor $transcriptor,
        private string $transcriptionId,
    ) {
    }

    public function handle(): void
    {
        $elasticSearch = new ElasticSearch();

        $result = $this->transcriptor->getResult($this->transcriptionId);

        $this->podcast->text_contents = $result->text;

        $elasticSearch->addToIndex($this->podcast->id, [
            'text_contents' => $this->podcast->text_contents,
        ]);

        $this->podcast->saveOrFail();

        event(new PodcastProceeded($this->podcast));
    }
}
