<?php

namespace App\Http\Controllers;

use App\Models\Podcast;
use App\Services\Podcast\Processor\Processor;
use Illuminate\Http\Request;

class PodcastController extends Controller
{
    public function __construct(private Processor $processor)
    {
    }

    public function uploadPodcast()
    {
//        $file = file_get_contents('../storage/app/podcasts/bvKcUylEaWGQN1qaw0TDxIq1ofhIz0R0tbbvPeFl.mp3');
        $podcast = Podcast::first();
        $podcast->uploaded_file_name = 'bvKcUylEaWGQN1qaw0TDxIq1ofhIz0R0tbbvPeFl.mp3';
        $podcast->save();

        $this->processor->process($podcast);
    }
}
