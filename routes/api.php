<?php

use App\Http\Controllers\Api\ProjectController as PC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AdController;
use App\Http\Controllers\Api\ProjectsGroupsController;
use App\Http\Controllers\Api\CategoryController;
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

// роуты по объявлениям
    Route::group(['prefix' => 'ads'], function () {
        Route::get('/', [AdController::class, 'index']);
        Route::post('add', [AdController::class, 'store']);
        Route::get('get', [AdController::class, 'show']);
        Route::get('getfa', [AdController::class, 'uploadAdsFromAvito']);
        Route::patch('update', [AdController::class, 'update']);
        Route::delete('delete', [AdController::class, 'destroy']);
    });

// роуты категорий
    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::post('add', [CategoryController::class, 'store']);
        Route::get('get', [CategoryController::class, 'show']);
        Route::patch('update', [CategoryController::class, 'update']);
        Route::delete('delete', [CategoryController::class, 'destroy']);
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


