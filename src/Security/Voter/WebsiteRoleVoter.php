<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Security\Permission;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use function in_array;

final class WebsiteRoleVoter implements VoterInterface
{
    public function __construct(
        private readonly AuthorizationCheckerInterface $authorizationChecker,
    ) {
    }

    public function vote(TokenInterface $token, mixed $subject, array $attributes): int
    {
        $attribute = $attributes[0];

        if (!in_array($attribute, [
            Permission::EDIT_PROJECT,
            Permission::EDIT_EVENT,
        ], true)) {
            return self::ACCESS_ABSTAIN;
        }

        return $this->authorizationChecker->isGranted('ROLE_WEBSITE') ? self::ACCESS_GRANTED : self::ACCESS_ABSTAIN;
    }
}
