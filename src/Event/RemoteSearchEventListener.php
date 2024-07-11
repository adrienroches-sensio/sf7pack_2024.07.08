<?php

declare(strict_types=1);

namespace App\Event;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
final class RemoteSearchEventListener
{
    public function __invoke(RemoteSearchEvent $event): void
    {
        dump($event);
    }
}
