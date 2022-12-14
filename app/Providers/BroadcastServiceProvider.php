<?php

namespace App\Providers;

use App\Models\Podcast;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes(['middleware' => ['auth:sanctum']]);

        require base_path('routes/channels.php');

        Broadcast::channel("podcasts.{podcast}", function ($user, Podcast $podcast) {
            return $user->id === $podcast->user_id;
        });
    }
}
