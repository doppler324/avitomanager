<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\projectRequest;
use App\Models\GroupsProjects;
use App\Models\ProjectAvito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectAvitoApiController extends Controller{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $projects = ProjectAvito::all();
        return response()->json([
            "success" => true,
            "message" => "Проекты успешно загружены.",
            "projectsgroups" => $projects
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, projectRequest $req): \Illuminate\Http\JsonResponse
    {
        // получаем данные из запроса
        $input = $request->all();
        // добавляем проект
        $project = new ProjectAvito($input);
        $project->save();

        return response()->json([
            "success" => true,
            "message" => "Проект добавлен успешно."
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): \Illuminate\Http\JsonResponse
    {
        $project = ProjectAvito::find($id);
        if (is_null($project)) {
            return response()->json([
                "success" => false,
                "message" => "Проект не найден."
            ]);
        }
        return response()->json([
            "success" => true,
            "message" => "Группа проектов успешно найдена.",
            "data" => $project
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id, projectRequest $req): \Illuminate\Http\JsonResponse
    {
        $input = $request->all();
        $project = ProjectAvito::find($id);
        $project->name = $input['name'];
        $project->user_id = $input['user_id'];
        $project->save();
        return response()->json([
            "success" => true,
            "message" => "Проект обновлен успешно."
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $project = ProjectAvito::find($id);
        $project->delete();
        return response()->json([
            "success" => true,
            "message" => "Группа проектов успешно удалена."
        ]);
    }
}
