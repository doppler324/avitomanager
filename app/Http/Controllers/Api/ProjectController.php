<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\projectRequest;
use App\Models\ProjectModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Components\Avito\AvitoApiComponent;

class ProjectController extends Controller
{

    /**
     * Отображает список проектов.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $projects = ProjectModel::where('user_id', Auth::id())->get();
        return response()->json([
            "success" => true,
            "message" => "Проекты успешно загружены.",
            "projects" => $projects
        ]);
    }

    /**
     * Добавляет проект.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, projectRequest $req): \Illuminate\Http\JsonResponse
    {
        $input = $request->all();
        $project = new ProjectModel($input);
        $project->save();
        return response()->json([
            "success" => true,
            "message" => "Проект добавлен успешно."
        ]);
    }

    /**
     * Отображает определенный проект.
     *
     * @param Request $request
     * @param projectRequest $req
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, projectRequest $req): \Illuminate\Http\JsonResponse
    {
        $project = ProjectModel::find($request->id);
        return response()->json([
            "success" => true,
            "message" => "Проект успешно найден."
        ]);
    }

    /**
     * Обновляет проект.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, projectRequest $req): \Illuminate\Http\JsonResponse
    {
        $input = $request->all();
        $project = ProjectModel::find($input['id']);
        $project->forceFill(request()->all())->save();
        return response()->json([
            "success" => true,
            "message" => "Проект обновлен успешно."
        ]);
    }

    /**
     * Обновляет проект с Авито.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateWithAvito(Request $request, projectRequest $req): \Illuminate\Http\JsonResponse
    {
        $input = $request->all();
        $result["project"] = AvitoApiComponent::loadInfoProject($input['id']);
        $result["balance"] = AvitoApiComponent::loadBalance($input['id']);
        $result["ads"] = AvitoApiComponent::loadBalance($input['id']);
        if(
            $result["project"]["success"] === false
            || $result["balance"]["success"] === false
            || $result["ads"]["success"] === false
        ){
            return response()->json([
                "success" => false,
                "message" => [
                    "project" => $result["project"]["message"],
                    "balance" => $result["balance"]["message"],
                    "ads" => $result["ads"]["message"],
                ],
                "messageFromAvito" => [
                    "project" => $result["project"]["messageFromAvito"],
                    "balance" => $result["balance"]["messageFromAvito"],
                    "ads" => $result["ads"]["messageFromAvito"],
                ]
            ]);
        }
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
    public function destroy(Request $request, projectRequest $req): \Illuminate\Http\JsonResponse
    {
        $input = $request->all();
        $project = ProjectModel::find($input['id']);
        $project->delete();
        return response()->json([
            "success" => true,
            "message" => "Проект успешно удален."
        ]);
    }
}
