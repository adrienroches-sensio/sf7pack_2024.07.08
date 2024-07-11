<?php

declare(strict_types=1);

namespace App\Search\Event;

final class ApiEventSearch implements EventSearchInterface
{
    public function __construct(
        private readonly string $deveventsApiKey,
    ) {
    }

    public function searchByName(?string $name = null): array
    {
        // TODO: Implement searchByName() method.
    }
}
