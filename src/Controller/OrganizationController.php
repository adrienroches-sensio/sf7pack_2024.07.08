<?php

namespace App\Controller;

use App\Entity\Organization;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrganizationController extends AbstractController
{
    #[Route('/organization/{id}', name: 'app_organization_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showOrg(Organization $organization): Response
    {
        return $this->render('organization/show_organization.html.twig', [
            'organization' => $organization,
        ]);
    }
}
