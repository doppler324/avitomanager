<?php

use App\Http\Controllers\Api\ProjectAvitoApiController as PC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\AdAvitoApiController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// роуты по пользователю
Route::get('user/{id}', [UserApiController::class, 'getUser']);
Route::get('users', [UserApiController::class, 'getUsers']);

// роуты по объявлениям
Route::get('ad/{id}', [AdAvitoApiController::class, 'getAd']);
Route::get('ads', [AdAvitoApiController::class, 'getAds']);
Route::get('user_ads/{user_id}', [AdAvitoApiController::class, 'getProjectAds']);

// роуты проектов
Route::get('projects', [PC::class, 'getProjects']);

