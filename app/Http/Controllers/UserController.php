<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\WatchlistRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function editUser(UserRequest $request): Response|Application|ResponseFactory
    {

        $response = [

        ];
        return response($response, 201);
    }

    public function deleteUser(): Response|Application|ResponseFactory
    {

        $response = [

        ];
        return response($response, 201);
    }

    public function setUserRole($role): Response|Application|ResponseFactory
    {

        $response = [

        ];
        return response($response, 201);
    }

    public function addToWatchlist(WatchlistRequest $request): Response|Application|ResponseFactory
    {

        $response = [

        ];
        return response($response, 201);
    }

    public function removeFromWatchlist($title): Response|Application|ResponseFactory
    {

        $response = [

        ];
        return response($response, 201);
    }

    public function getProjectAnalytics($title): Response|Application|ResponseFactory
    {

        $response = [

        ];
        return response($response, 201);
    }


}
