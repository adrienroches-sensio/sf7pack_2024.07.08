<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Security\Permission;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProjectController extends AbstractController
{
    #[Route('/projects', name: 'app_project_list', methods: ['GET'])]
    public function index(ProjectRepository $repository): Response
    {
        $projects = $repository->findAll();

        return $this->render('project/list_projects.html.twig', [
            'projects' => $projects,
        ]);
    }

    #[Route('/project/{id}', name: 'app_project_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showProject(Project $project): Response
    {
        return $this->render('project/show_project.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route('/project/new', name: 'app_project_new', methods: ['GET', 'POST'])]
    #[Route('/project/{id}/edit', name: 'app_project_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function newProject(Request $request, Project|null $project, EntityManagerInterface $em): Response
    {
        if (null !== $project) {
            $this->denyAccessUnlessGranted(Permission::EDIT_PROJECT, $project);
        }

        $project ??= new Project();
        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $project->setCreatedAt(new DateTimeImmutable());

            if ($project->isNew()) {
                $project->setCreatedBy($this->getUser());
            }

            $em->persist($project);
            $em->flush();

            return $this->redirectToRoute('app_project_show', ['id' => $project->getId()]);
        }

        return $this->render('project/new_project.html.twig', [
            'form' => $form,
        ]);
    }
}
