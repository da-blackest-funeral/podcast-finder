<?php

namespace App\Providers;

use App\Services\Podcast\Processor\AssemblyAIProcessor;
use App\Services\Podcast\Processor\Processor;
use App\Services\Podcast\Transcriptor\AssemblyAITrancriptor;
use App\Services\Podcast\Transcriptor\MockTranscriptor;
use App\Services\Podcast\Transcriptor\Transcriptor;
use App\Services\Podcast\Uploader\AssemblyAIUploader;
use App\Services\Podcast\Uploader\PodcastUploader;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Transcriptor::class, MockTranscriptor::class);
        $this->app->bind(PodcastUploader::class, AssemblyAIUploader::class);
        $this->app->bind(Processor::class, function () {
            return new AssemblyAIProcessor(
                $this->app->make(PodcastUploader::class),
                $this->app->make(Transcriptor::class),
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
