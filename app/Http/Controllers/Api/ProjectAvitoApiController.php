<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProjectAvito;

class ProjectAvitoApiController extends Controller{
  public function getProjects(){
    $projects = ProjectAvito::all()->toJson(JSON_PRETTY_PRINT);
    return response($projects, 200);
  }
}
