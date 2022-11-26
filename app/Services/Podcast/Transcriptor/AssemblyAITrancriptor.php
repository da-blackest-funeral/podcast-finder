<?php

namespace App\Services\Podcast\Transcriptor;

use App\DTO\StartTranscriptionResponse;
use App\DTO\TranscriptionResult;
use App\DTO\UploadResponse;
use App\Models\Podcast;

class AssemblyAITrancriptor implements Transcriptor
{
    private string $apiToken;

    public function __construct()
    {
        $this->apiToken = config('assembly_ai.api_token');
    }

    /**
     * @throws \JsonException
     */
    public function startTranscription(Podcast $podcast, string $uploadUrl): StartTranscriptionResponse
    {
        $curl = $this->prepareRequest($uploadUrl);

        $response = curl_exec($curl);

        return StartTranscriptionResponse::fromArray(
            json_decode($response, true, 512, JSON_THROW_ON_ERROR)
        );
    }

    public function getResult(string $transcriptionId): TranscriptionResult
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.assemblyai.com/v2/transcript/' . $transcriptionId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                "authorization: $this->apiToken",
                'content-type: application/json',
            ],
        ]);

        $response = curl_exec($curl);

        return TranscriptionResult::fromArray(
            json_decode($response, true, 512, JSON_THROW_ON_ERROR)
        );
    }

    /**
     * @throws \JsonException
     */
    private function prepareRequest(string $uploadUrl): \CurlHandle|bool
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.assemblyai.com/v2/transcript',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode(['audio_url' => $uploadUrl], JSON_THROW_ON_ERROR),
            CURLOPT_HTTPHEADER => [
                "authorization: $this->apiToken",
                'content-type: application/json',
            ],
        ]);

        return $curl;
    }
}
