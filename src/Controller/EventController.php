<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Search\Event\DatabaseEventSearch;
use App\Search\Event\EventSearchInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    #[Route('/event/new',
        name: 'app_event_new',
        methods: ['GET', 'POST']
    )]
    public function newEvent(Request $request, EntityManagerInterface $em): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $event->setCreatedBy($this->getUser());

            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('app_event_show', ['id' => $event->getId()]);
        }

        return $this->render('event/new_event.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/events', name: 'app_event_list', methods: ['GET'])]
    public function listEvents(Request $request, DatabaseEventSearch $eventSearch): Response
    {
        $events = $eventSearch->searchByName($request->query->get('name', null));

        return $this->render('event/list_events.html.twig', [
            'events' => $events,
        ]);
    }

    #[Route(
        '/events/search',
        name: 'app_event_search',
        methods: ['GET']
    )]
    #[Template('event/search_events.html.twig')]
    public function searchEvents(Request $request, EventSearchInterface $search): array
    {
        $events = $search->searchByName($request->query->get('name', null))['hydra:member'];

        return ['events' => $events];
    }

    #[Route('/events/{id}', name: 'app_event_show', methods: ['GET'])]
    public function showEvent(Event $event): Response
    {
        return $this->render('event/show_event.html.twig', [
            'event' => $event,
        ]);
    }
}
