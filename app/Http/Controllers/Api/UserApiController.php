<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserApiController extends Controller
{
  public function getUser($id){
    if (User::query()->where('id', $id)->exists()) {
      $user = User::query()->where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
      return response($user, 200);
    } else {
      return response()->json([
        "message" => "User not found"
      ], 404);
    }
  }

  public function getUsers(){
    $users = User::all()->toJson(JSON_PRETTY_PRINT);
    return response($users, 200);
  }
}
