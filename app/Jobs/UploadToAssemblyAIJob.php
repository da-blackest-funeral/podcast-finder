<?php

namespace App\Jobs;

use App\Events\PodcastUploaded;
use App\Models\Podcast;
use App\Services\Podcast\Uploader\PodcastUploader;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UploadToAssemblyAIJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public PodcastUploader $uploader,
        public Podcast $podcast
    ) {
    }

    public function handle()
    {
        $response = $this->uploader->upload($this->podcast);

        event(new PodcastUploaded($this->podcast, $response));
    }
}
