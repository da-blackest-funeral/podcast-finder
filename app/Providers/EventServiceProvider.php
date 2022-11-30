<?php

namespace App\Providers;

use App\Events\PodcastUploaded;
use App\Services\Podcast\Processor\Processor;
use App\Services\Podcast\Transcriptor\Transcriptor;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    public function boot()
    {
        Event::listen(static function (PodcastUploaded $event) {
            app(Processor::class)
                ->transcript($event);
        });
    }

    public function shouldDiscoverEvents()
    {
        return false;
    }
}
