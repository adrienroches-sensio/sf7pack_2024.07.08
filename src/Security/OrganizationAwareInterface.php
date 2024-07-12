<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\Organization;
use Doctrine\Common\Collections\Collection;

interface OrganizationAwareInterface
{
    /**
     * @return Collection<int, Organization>
     */
    public function getOrganizations(): Collection;
}
