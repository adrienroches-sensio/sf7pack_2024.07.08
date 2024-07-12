<?php

declare(strict_types=1);

namespace App\Event;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[AsEventListener]
final class RemoteSearchEventListener
{
    public function __construct(
        private readonly AuthorizationCheckerInterface $authorizationChecker,
    ) {
    }

    public function __invoke(RemoteSearchEvent $event): void
    {
        if (
            !$this->authorizationChecker->isGranted('ROLE_ORGANIZER')
            && !$this->authorizationChecker->isGranted('ROLE_WEBSITE')
        ) {
            return;
        }

        // User is either ROLE_ORGANIZER or ROLE_WEBSITE
        dump($event);
    }
}
