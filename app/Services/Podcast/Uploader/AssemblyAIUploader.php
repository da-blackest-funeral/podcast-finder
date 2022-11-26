<?php

namespace App\Services\Podcast\Uploader;

use App\DTO\UploadResponse;
use App\Models\Podcast;

class AssemblyAIUploader implements PodcastUploader
{
    private string $apiToken;

    private Podcast $podcast;

    public function __construct()
    {
        $this->apiToken = config('assembly_ai.api_token');
    }

    public function upload(Podcast $podcast): UploadResponse
    {
        $this->podcast = $podcast;

        $curl = $this->prepareRequest();
        $response = $this->submitRequest($curl);

        return UploadResponse::fromArray(
            json_decode($response, true, 512, JSON_THROW_ON_ERROR)
        );
    }

    private function prepareRequest(): \CurlHandle|bool
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => config('assembly_ai.upload_endpoint'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => file_get_contents($this->getFileName()),
            CURLOPT_HTTPHEADER => [
                "authorization: $this->apiToken",
            ],
        ]);

        return $curl;
    }

    private function getFileName(): string
    {
        return "../storage/app/podcasts/{$this->podcast->uploaded_file_name}";
    }

    private function submitRequest($curl): bool|string
    {
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}
