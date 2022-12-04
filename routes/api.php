<?php

use App\Http\Controllers\Api\ProjectAvitoApiController as PC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\AdAvitoApiController;
use App\Http\Controllers\Api\ProjectsGroupsController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "Api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
    });
});

Route::group(['middleware' => 'auth:sanctum'], function() {
// роуты по пользователю
    Route::get('user/{id}', [UserApiController::class, 'getUser']);
    Route::get('users', [UserApiController::class, 'getUsers']);

// роуты по объявлениям
    Route::get('ad/{id}', [AdAvitoApiController::class, 'getAd']);
    Route::get('ads', [AdAvitoApiController::class, 'getAds']);
    Route::get('user_ads/{user_id}', [AdAvitoApiController::class, 'getProjectAds']);

// роуты проектов
    Route::get('projects', [PC::class, 'getProjects']);

// роуты групп проектов
    Route::group(['prefix' => 'groupsprojects'], function () {
        Route::get('/', [ProjectsGroupsController::class, 'index']);
        Route::get('add', [ProjectsGroupsController::class, 'store']);
        Route::get('get/{id}', [ProjectsGroupsController::class, 'show']);
        Route::get('update/{id}', [ProjectsGroupsController::class, 'update']);
        Route::get('delete/{id}', [ProjectsGroupsController::class, 'destroy']);
    });
});


