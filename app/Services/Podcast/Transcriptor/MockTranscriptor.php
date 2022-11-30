<?php

namespace App\Services\Podcast\Transcriptor;

use App\DTO\StartTranscriptionResponse;
use App\DTO\TranscriptionResult;
use App\Models\Podcast;

class MockTranscriptor implements Transcriptor
{
    public function startTranscription(Podcast $podcast, string $uploadUrl): StartTranscriptionResponse
    {
        return new StartTranscriptionResponse('rbcop3zwlq-6b5e-4866-b83f-3e98a81a76a6');
    }

    /**
     * @throws \JsonException
     */
    public function getResult(string $transcriptionId): TranscriptionResult
    {
        return (new AssemblyAITrancriptor())
            ->getResult($transcriptionId);
    }
}
