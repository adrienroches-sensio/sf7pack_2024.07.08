<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Repository\VolunteerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class VolunteerController extends AbstractController
{
    #[Route('/api/volunteers', name: 'app_api_volunteers')]
    public function list(VolunteerRepository $volunteerRepository): array
    {
        return $volunteerRepository->findAll();
    }
}
