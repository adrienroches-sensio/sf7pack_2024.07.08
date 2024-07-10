<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Project;
use App\Entity\Volunteer;
use App\Form\VolunteerType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VolunteerController extends AbstractController
{
    #[Route('/volunteer/{id}', name: 'app_volunteer_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showVolunteer(Volunteer $volunteer): Response
    {
        return $this->render('volunteer/show_volunteer.html.twig', [
            'volunteer' => $volunteer,
        ]);
    }

    #[Route('/volunteer/new', name: 'app_volunteer_new', methods: ['GET', 'POST'])]
    public function newVolunteer(Request $request, EntityManagerInterface $manager): Response
    {
        $volunteer = (new Volunteer())->setForUser($this->getUser());
        $options = [];

        if ($request->query->has('event')) {
            $event = $manager->find(Event::class, $request->query->get('event'));
            $volunteer->setEvent($event);
            $options['event'] = $event;
        }
        if ($request->query->has('project')) {
            $project = $manager->find(Project::class, $request->query->get('project'));
            $volunteer->setProject($project);
            $options['project'] = $project;
        }

        $form = $this->createForm(VolunteerType::class, $volunteer, $options);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($volunteer->getEvent() && !$volunteer->getProject()) {
                $volunteer->setProject($volunteer->getEvent()->getProject());
            }
            $manager->persist($volunteer);
            $manager->flush();

            return $this->redirectToRoute('app_volunteer_show', ['id' => $volunteer->getId()]);
        }

        return $this->render('volunteer/new_volunteer.html.twig', [
            'form' => $form,
        ]);
    }
}
