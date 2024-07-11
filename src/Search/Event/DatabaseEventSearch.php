<?php

declare(strict_types=1);

namespace App\Search\Event;

use App\Entity\Event;
use App\Repository\EventRepository;

final class DatabaseEventSearch
{
    public function __construct(
        private readonly EventRepository $eventRepository,
    ) {
    }

    /**
     * @return list<Event>
     */
    public function searchByName(string|null $name = null): array
    {
        if (null === $name) {
            return $this->eventRepository->listAll();
        }

        return $this->eventRepository->searchByName($name);
    }
}
