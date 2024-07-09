<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_main_index')]
    public function index(Request $request): Response
    {
        $name = $request->query->get('name', 'World');

        return $this->render('main/index.html.twig', [
            'name' => $name,
        ]);
    }

    #[Route('/contact', name: 'app_main_contact')]
    #[Template('main/contact.html.twig')]
    public function contact(): array
    {
        return [];
    }
}
