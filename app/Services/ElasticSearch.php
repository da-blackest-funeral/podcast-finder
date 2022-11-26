<?php

namespace App\Services;

use App\Models\Podcast;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class ElasticSearch
{
    private Client $client;

    /**
     * @throws AuthenticationException
     */
    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts(['http://elasticsearch:9200'])
            ->build();
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function addToIndex($id, array $content): void
    {
        $this->client->index([
            'index' => 'podcasts',
            'id' => $id,
            'body' => $content,
        ]);
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function getBySearch(string $search): array
    {
        $result = $this->client->search([
            'index' => 'podcasts',
            'body' => [
                'query' => [
                    'match' => (object)[
                        'text_contents' => [
                            'query' => $search,
                        ],
                    ],
                ],
            ],
        ])->asObject();

        $ids = collect($result->hits->hits)
            ->pluck('_id');

        return Podcast::whereIn('id', $ids)
            ->get()
            ->toArray();
    }
}
