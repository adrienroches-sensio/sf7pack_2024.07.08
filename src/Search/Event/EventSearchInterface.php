<?php

declare(strict_types=1);

namespace App\Search\Event;

use App\Entity\Event;

interface EventSearchInterface
{
    /**
     * @return list<Event>
     */
    public function searchByName(string|null $name = null): array;
}
