<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class PictureController extends Controller
{
    public function getPicture($type, $filename): Response|Application|ResponseFactory
    {
        return response(Storage::get("pictures/$type/$filename.webp"), 200);
    }
}
