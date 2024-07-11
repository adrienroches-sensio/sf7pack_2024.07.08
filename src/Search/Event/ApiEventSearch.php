<?php

declare(strict_types=1);

namespace App\Search\Event;

use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ApiEventSearch implements EventSearchInterface
{
    public function __construct(
        private readonly HttpClientInterface $deveventsClient,
    ) {
    }

    public function searchByName(?string $name = null): array
    {
        return $this->deveventsClient->request('GET', '/events', [
            'query' => [
                'name' => $name ?? '',
            ],
        ])->toArray();
    }
}
