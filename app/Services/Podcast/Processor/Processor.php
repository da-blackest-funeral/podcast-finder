<?php

namespace App\Services\Podcast\Processor;

// todo get response from server and write text to podcast
use App\Models\Podcast;

interface Processor
{
    public function process(Podcast $podcast);
}
