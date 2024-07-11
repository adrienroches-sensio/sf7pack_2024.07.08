<?php

declare(strict_types=1);

namespace App\Search\Event;

use App\Entity\Event;

final class DatabaseEventSearch
{
    /**
     * @return list<Event>
     */
    public function searchByName(string|null $name = null): array
    {
        return [];
    }
}
