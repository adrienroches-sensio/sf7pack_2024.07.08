<?php

declare(strict_types=1);

namespace App\Security;

use Symfony\Component\Security\Core\User\UserInterface;

interface CreatorAwareInterface
{
    public function getCreatedBy(): UserInterface|null;
}
