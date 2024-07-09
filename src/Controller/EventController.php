<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    #[Route('/event/{name}/{start}/{end}', name: 'app_event_new')]
    public function newEvent(string $name, string $start, string $end, /* ... */): Response
    {
        $event = (new Event())
            ->setName($name)
            ->setDescription('Some generic description')
            ->setAccessible(true)
            ->setStartAt(new \DateTimeImmutable($start))
            ->setEndAt(new \DateTimeImmutable($end))
        ;

        //...

        return new Response('Event created');
    }
}
