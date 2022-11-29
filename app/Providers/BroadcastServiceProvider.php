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
        Broadcast::routes();

        require base_path('routes/channels.php');

        Broadcast::channel('podcasts.{id}', function ($user, $id) {
            return $user->id === Podcast::find($id)->user_id;
        });
    }
}
