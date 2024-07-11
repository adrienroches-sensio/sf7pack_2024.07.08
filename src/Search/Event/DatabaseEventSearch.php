<?php

declare(strict_types=1);

namespace App\Search\Event;

use App\Repository\EventRepository;

final class DatabaseEventSearch implements EventSearchInterface
{
    public function __construct(
        private readonly EventRepository $eventRepository,
    ) {
    }

    public function searchByName(string|null $name = null): array
    {
        if (null === $name) {
            return $this->eventRepository->listAll();
        }

        return $this->eventRepository->searchByName($name);
    }
}
