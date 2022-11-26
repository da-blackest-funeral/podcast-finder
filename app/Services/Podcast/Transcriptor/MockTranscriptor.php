<?php

namespace App\Services\Podcast\Transcriptor;

use App\DTO\StartTranscriptionResponse;
use App\DTO\TranscriptionResult;
use App\Models\Podcast;

class MockTranscriptor implements Transcriptor
{
    public function startTranscription(Podcast $podcast, string $uploadUrl): StartTranscriptionResponse
    {
        return new StartTranscriptionResponse('rb6rrlewov-6430-49cd-9191-9ae8f0d466ae');
    }

    public function getResult(string $transcriptionId): TranscriptionResult
    {

    }
}
