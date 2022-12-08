<?php

use App\Http\Controllers\Api\ProjectController as PC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\AdAvitoApiController;
use App\Http\Controllers\Api\ProjectsGroupsController;
use App\Http\Controllers\Api\CategoryAvitoController;
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
    Route::group(['prefix' => 'ads'], function () {
        Route::get('/', [AdAvitoApiController::class, 'index']);
        Route::post('add', [AdAvitoApiController::class, 'store']);
        Route::get('get', [AdAvitoApiController::class, 'show']);
        Route::patch('update', [AdAvitoApiController::class, 'update']);
        Route::delete('delete', [AdAvitoApiController::class, 'destroy']);
    });

// роуты категорий
    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', [CategoryAvitoController::class, 'index']);
        Route::post('add', [CategoryAvitoController::class, 'store']);
        Route::get('get', [CategoryAvitoController::class, 'show']);
        Route::patch('update', [CategoryAvitoController::class, 'update']);
        Route::delete('delete', [CategoryAvitoController::class, 'destroy']);
    });

// роуты проектов
    Route::group(['prefix' => 'projects'], function () {
        Route::get('/', [PC::class, 'index']);
        Route::post('add', [PC::class, 'store']);
        Route::get('get', [PC::class, 'show']);
        Route::patch('update', [PC::class, 'update']);
        Route::patch('updatewithavito', [PC::class, 'updateWithAvito']);
        Route::delete('delete', [PC::class, 'destroy']);
    });

// роуты групп проектов
    Route::group(['prefix' => 'groupsprojects'], function () {
        Route::get('/', [ProjectsGroupsController::class, 'index']);
        Route::post('add', [ProjectsGroupsController::class, 'store']);
        Route::get('get', [ProjectsGroupsController::class, 'show']);
        Route::patch('update', [ProjectsGroupsController::class, 'update']);
        Route::delete('delete', [ProjectsGroupsController::class, 'destroy']);
    });
});


