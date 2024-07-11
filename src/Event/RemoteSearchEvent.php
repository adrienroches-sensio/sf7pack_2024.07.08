<?php

declare(strict_types=1);

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

final class RemoteSearchEvent extends Event
{
    /**
     * @param list<array{}> $events
     */
    public function __construct(
        public readonly array $events,
    ) {
    }
}
