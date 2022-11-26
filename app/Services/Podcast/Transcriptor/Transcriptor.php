<?php

namespace App\Services\Podcast\Transcriptor;

use App\DTO\StartTranscriptionResponse;
use App\DTO\TranscriptionResult;
use App\Models\Podcast;

interface Transcriptor
{
    public function startTranscription(Podcast $podcast, string $uploadUrl): StartTranscriptionResponse;

    public function getResult(string $transcriptionId): TranscriptionResult;
}
