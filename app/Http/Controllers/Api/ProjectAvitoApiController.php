<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectsGroupsRequest;
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
        $projectsgroups = Projects::all();
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
    public function store(Request $request, ProjectsGroupsRequest $req): \Illuminate\Http\JsonResponse
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
    public function show($id): \Illuminate\Http\JsonResponse
    {
        $projectgroup = GroupsProjects::find($id);
        if (is_null($projectgroup)) {
            return response()->json([
                "success" => false,
                "message" => "Группа проектов не найдена."
            ]);
        }
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
    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'user_id' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Ошибка валидации.', $validator->errors());
        }
        $projectgroup = GroupsProjects::find($id);
        $projectgroup->name = $input['name'];
        $projectgroup->user_id = $input['user_id'];
        $projectgroup->save();
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
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $projectgroup = GroupsProjects::find($id);
        $projectgroup->delete();
        return response()->json([
            "success" => true,
            "message" => "Группа проектов успешно удалена.",
            "data" => $projectgroup
        ]);
    }
}
