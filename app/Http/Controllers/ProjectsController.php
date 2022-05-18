<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\GeneratedProject;
use App\Models\Project;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use JetBrains\PhpStorm\ArrayShape;

class ProjectsController extends Controller
{
    #[ArrayShape(['projects' => "mixed"])] public function getTopTenLuck(): array
    {
        $projectModel = new Project();
        $projects = $projectModel->findTopTenLuck();
        return [
            'projects' => $projects,
        ];
    }

    #[ArrayShape(['projects' => Collection::class])] public function getTopTenLike(): array
    {
        $projectModel = new Project();
        $projects = $projectModel->findTopTenLike();
        return [
            'projects' => $projects,
        ];
    }

    #[ArrayShape(['projects' => "mixed"])] public function generateProjects($numberOfProjects): void
    {
        $projectModel = new Project();
        $projects = $projectModel->findRandomProjectIds($numberOfProjects);
        $generatedProjectModel = new GeneratedProject();
        foreach ($projects as $projectId) {
            $generatedProjectModel->createProject($projectId['id']);
        }
    }

    public function getNewProjects(): Response|Application|ResponseFactory
    {
        $response = [
            'message' => 'Ok',
        ];
        return response($response, 201);
    }

    public function getRecommendedProjects(): Response|Application|ResponseFactory
    {
        $response = [
            'message' => 'Ok',
        ];
        return response($response, 201);
    }

    /**
     * @throws Exception
     */
    public function createProject(ProjectRequest $request): Response|Application|ResponseFactory
    {
        $projectModel = new Project();
        $project = $request->validated();
        $projectModel->createProject($project);
        $response = [
            'message' => 'Ok',
        ];
        return response($response, 201);
    }

    public function getUserProjects(): Response|Application|ResponseFactory
    {
        $projectModel = new Project();
        $projects = $projectModel->findUserProjects();
        $response = [
            'projects' => $projects,
        ];
        return response($response, 201);
    }

    public function getRankLuckResponse(): Response|Application|ResponseFactory
    {
        return response($this->getTopTenLuck(), 201);
    }

    public function getRankLikeResponse(): Response|Application|ResponseFactory
    {
        return response($this->getTopTenLike(), 201);
    }

    public function getRank($type): Response|Application|ResponseFactory
    {
        if ($type === 'luck') {
            return response($this->getTopTenLuck(), 201);
        }

        return response($this->getTopTenLike(), 201);

    }

    public function getGeneratedProjectsResponse(): Response|Application|ResponseFactory
    {
        $model = new GeneratedProject();
        $projectModel = new Project();
        $generatedProjects = $model->findLast(5);
        $projects = [];
        foreach ($generatedProjects as $projectId) {
            $projects[] = $projectModel->findProjectById($projectId['project_id']);
        }
        $response = [
            'projects' => $projects,
        ];
        return response($response, 201);
    }

}
