<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Repository\VolunteerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

class VolunteerController extends AbstractController
{
    #[IsGranted('IS_AUTHENTICATED')]
    #[Route('/api/volunteers', name: 'app_api_volunteers')]
    public function list(SerializerInterface $serializer, VolunteerRepository $volunteerRepository): JsonResponse
    {
        return new JsonResponse(
            $serializer->serialize($volunteerRepository->listAll(), 'json', [
                'groups' => ['Volunteer'],
            ]),
            json: true
        );
    }
}
