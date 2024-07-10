<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
