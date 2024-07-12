<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Security\CreatorAwareInterface;
use App\Security\Permission;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use function in_array;

final class CreatorVoter implements VoterInterface
{
    public function vote(TokenInterface $token, mixed $subject, array $attributes): int
    {
        if (!$subject instanceof CreatorAwareInterface) {
            return self::ACCESS_ABSTAIN;
        }

        if ($subject->getCreatedBy() === null) {
            return self::ACCESS_ABSTAIN;
        }

        $attribute = $attributes[0];

        if (!in_array($attribute, [
            Permission::EDIT_PROJECT,
            Permission::EDIT_EVENT,
        ], true)) {
            return self::ACCESS_ABSTAIN;
        }

        $user = $token->getUser();
        if (!$user instanceof EquatableInterface) {
            return self::ACCESS_DENIED;
        }

        return $user->isEqualTo($subject->getCreatedBy()) ? self::ACCESS_GRANTED : self::ACCESS_DENIED;
    }
}
