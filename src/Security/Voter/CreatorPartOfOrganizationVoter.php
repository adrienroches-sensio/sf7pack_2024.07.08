<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Security\CreatorAwareInterface;
use App\Security\OrganizationAwareInterface;
use App\Security\Permission;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use function in_array;

final class CreatorPartOfOrganizationVoter implements VoterInterface
{

    public function vote(TokenInterface $token, mixed $subject, array $attributes): int
    {
        if (!$subject instanceof CreatorAwareInterface) {
            return self::ACCESS_ABSTAIN;
        }

        if (!$subject instanceof OrganizationAwareInterface) {
            return self::ACCESS_ABSTAIN;
        }

        if ($subject->getCreatedBy() === null || $subject->getOrganizations()->isEmpty()) {
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
        if (!$user instanceof OrganizationAwareInterface) {
            return self::ACCESS_DENIED;
        }

        foreach ($subject->getOrganizations() as $organization) {
            if ($user->getOrganizations()->contains($organization)) {
                return self::ACCESS_GRANTED;
            }
        }

        return self::ACCESS_DENIED;
    }
}
