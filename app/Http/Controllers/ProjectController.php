<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectEditRequest;
use App\Models\Likes;
use App\Models\Project;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class ProjectController extends Controller
{

    public function getProject($title): Response|Application|ResponseFactory
    {
        $response = [
            'message' => 'Ok',
        ];
        return response($response, 201);
    }

    public function getProjectAnalytics($title): Response|Application|ResponseFactory
    {
        $response = [
            'message' => 'Ok',
        ];
        return response($response, 201);
    }


    public function updateLikes($title): Response|Application|ResponseFactory
    {
        $likesModel = new Likes();
        $likesModel->switchLike($title);
        $response = [
            'message' => 'Ok',
        ];
        return response($response, 201);
    }

    /**
     * @throws Exception
     */
    public function editProject(ProjectEditRequest $request): Response|Application|ResponseFactory
    {
        $projectModel = new Project();
        $project = $request->validated();
        $projectModel->updateProject($project);
        $response = [
            'message' => 'Ok',
        ];
        return response($response, 201);
    }

    /**
     * @throws Exception
     */
    public function deleteProject($title): Response|Application|ResponseFactory
    {
        $projectModel = new Project();
        $projectModel->deleteProject($title);
        $response = [
            'message' => 'Ok',
        ];
        return response($response, 201);
    }
}
