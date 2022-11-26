<?php

namespace App\Services\Podcast\Processor;

use App\Models\Podcast;

interface Processor
{
    public function process(Podcast $podcast): void;
}
