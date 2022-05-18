<?php

namespace App\Http\Controllers;

use App\Models\Likes;
use App\Models\Project;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserActionController extends Controller
{


    public function getIsLiked($title): Application|ResponseFactory|Response
    {
        $likesModel = new Likes();
        $like = $likesModel->findLike($title);
        $isLiked = false;
        if ($like) {
            $isLiked = !$like['deleted'];
        }
        $response = [
            'message' => 'Ok',
            'isLiked' =>$isLiked
        ];
        return response($response, 201);
    }

}
