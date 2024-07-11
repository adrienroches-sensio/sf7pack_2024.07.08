<?php

declare(strict_types=1);

namespace App\Search\Event;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use function md5;

final class CachedEventSearch implements EventSearchInterface
{
    public function __construct(
        private readonly EventSearchInterface $inner,
        private readonly CacheInterface $cache,
    ) {
    }

    public function searchByName(?string $name = null): array
    {
        return $this->cache->get(md5($name ?? '_all'), function (ItemInterface $item) use ($name) {
            $item->expiresAfter(3600); // cache for 1 hour.

            return $this->inner->searchByName($name);
        });
    }
}
