<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DataUpdateController;
use App\Http\Controllers\PictureController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UserActionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/generate', [DataUpdateController::class, 'generateProjects']);

Route::prefix('pictures')->group(static function () {
    Route::get('/{type}/{filename}', [PictureController::class, 'getPicture']);
});
Route::prefix('account')->group(static function () {
    Route::post('/connect', [AuthenticationController::class, 'connect']);
    Route::post('/sign', [AuthenticationController::class, 'sign']);
});

Route::prefix('projects')->group(static function () {
    Route::get('/rank/{type}', [ProjectsController::class, 'getRank']);
    Route::get('/generated', [ProjectsController::class, 'getGeneratedProjectsResponse']);
});


Route::group(['middleware' => ['auth:sanctum']], static function () {
    Route::prefix('projects')->group(static function () {
        Route::get('/new', [ProjectsController::class, 'getNewProjects']);
        Route::get('/recommended', [ProjectsController::class, 'getRecommendedProjects']);
        Route::post('/', [ProjectsController::class, 'createProject']);
        Route::prefix('/{title}')->group(static function () {
            Route::get('/', [ProjectController::class, 'getProject']);
            Route::put('/', [ProjectController::class, 'editProject']);
            Route::delete('/', [ProjectController::class, 'deleteProject']);
            Route::get('/like', [UserActionController::class, 'getIsLiked']);
            Route::post('/like', [ProjectController::class, 'updateLikes']);
            Route::get('/analytics', [UserController::class, 'getProjectAnalytics']);
        });
    });
    Route::prefix('transactions')->group(static function () {
        Route::post('/', [TransactionsController::class, 'createTransaction']);
        Route::put('/', [TransactionsController::class, 'editTransaction']);
    });

    Route::prefix('user')->group(static function () {
        Route::put('/', [UserController::class, 'editUser']);
        Route::delete('/', [UserController::class, 'deleteUser']);
        Route::post('/role/{role}', [UserController::class, 'setUserRole']);
        Route::prefix('/projects')->group(static function () {
            Route::get('/', [ProjectsController::class, 'getUserProjects']);
            Route::prefix('/watchlist')->group(static function () {
                Route::post('/', [UserController::class, 'addToWatchlist']);
                Route::delete('/{title}', [UserController::class, 'removeFromWatchlist']);
            });
        });
    });

    Route::prefix('account')->group(static function () {
        Route::get('/connected', [AuthenticationController::class, 'isConnected']);
        Route::get('/disconnect', [AuthenticationController::class, 'disconnect']);
    });
});
