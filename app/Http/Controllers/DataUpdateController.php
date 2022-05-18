<?php

namespace App\Http\Controllers;

class DataUpdateController extends Controller
{
    public function generateProjects(): void
    {
        $controller = new ProjectController();
        $controller->generateProjects(6);
    }
}
