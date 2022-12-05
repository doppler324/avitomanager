<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\projectsGroupsUpdateRequest;
use App\Models\GroupsProjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProjectsGroupsStoreRequest;
use Illuminate\Support\Facades\Auth;

class ProjectsGroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $projectsgroups = GroupsProjects::where('user_id', Auth::id())->get();
        return response()->json([
            "success" => true,
            "message" => "Список групп проектов успешно загружен.",
            "projectsgroups" => $projectsgroups
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, ProjectsGroupsStoreRequest $req): \Illuminate\Http\JsonResponse
    {
        // получаем данные из запроса
        $input = $request->all();
        // добавляем группу, если меньше 10 групп
        $groupProject = new GroupsProjects($input);
        $groupProject->save();

        return response()->json([
            "success" => true,
            "message" => "Группа проектов добавлена успешно."
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, ProjectsGroupsStoreRequest $req): \Illuminate\Http\JsonResponse
    {
        $input = $request->all();
        $projectgroup = GroupsProjects::find($input['id']);
        return response()->json([
            "success" => true,
            "message" => "Группа проектов успешно найдена.",
            "data" => $projectgroup
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, ProjectsGroupsStoreRequest $req): \Illuminate\Http\JsonResponse
    {
        $input = $request->all();
        $projectgroup = GroupsProjects::find($input['id']);
        $projectgroup->fill($request->all())->save();
        return response()->json([
            "success" => true,
            "message" => "Группа проектов обновлена успешно.",
            "data" => $projectgroup
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, ProjectsGroupsStoreRequest $req): \Illuminate\Http\JsonResponse
    {
        $input = $request->all();
        $projectgroup = GroupsProjects::find($input['id']);
        $projectgroup->delete();
        return response()->json([
            "success" => true,
            "message" => "Группа проектов успешно удалена."
        ]);
    }
}
