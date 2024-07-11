<?php

declare(strict_types=1);

namespace App\Search\Event;

use Symfony\Component\HttpClient\HttpClient;

final class ApiEventSearch implements EventSearchInterface
{
    public function __construct(
        private readonly string $deveventsApiKey,
    ) {
    }

    public function searchByName(?string $name = null): array
    {
        $client = HttpClient::create();

        return $client->request('GET', 'https://www.devevents-api.fr/events', [
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
