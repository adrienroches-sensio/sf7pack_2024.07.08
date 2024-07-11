<?php

declare(strict_types=1);

namespace App\Search\Event;

use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ApiEventSearch implements EventSearchInterface
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly string $deveventsApiKey,
    ) {
    }

    public function searchByName(?string $name = null): array
    {
        return $this->client->request('GET', 'https://www.devevents-api.fr/events', [
            'query' => [
                'name' => $name ?? '',
            ],
            'headers' => [
                'apikey' => $this->deveventsApiKey,
                'Accept' => 'application/json',
            ],
        ])->toArray();
    }
}
