<?php

declare(strict_types=1);

namespace App\Search\Event;

use App\Event\RemoteSearchEvent;
use Psr\EventDispatcher\EventDispatcherInterface;

final class ApiWatcherEventSearch implements EventSearchInterface
{
    public function __construct(
        private readonly EventSearchInterface $inner,
        private readonly EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function searchByName(?string $name = null): array
    {
        $result = $this->inner->searchByName($name);

        $this->eventDispatcher->dispatch(new RemoteSearchEvent($result));

        return $result;
    }
}
