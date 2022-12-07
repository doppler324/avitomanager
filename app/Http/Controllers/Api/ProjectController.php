<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\projectRequest;
use App\Models\ProjectAvito;
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
        $projects = ProjectAvito::where('user_id', Auth::id())->get();
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
        $project = new ProjectAvito($input);
        $project->save();
        return response()->json([
            "success" => true,
            "message" => "Проект добавлен успешно."
        ]);
    }

    /**
     * Отображает определенный проект.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, projectRequest $req): \Illuminate\Http\JsonResponse
    {
        $input = $request->all();
        $project = ProjectAvito::find($input['id']);
        return response()->json([
            "success" => true,
            "message" => "Проект успешно найден.",
            "data" =>  $project->getClientIdAttribute()
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
        $project = ProjectAvito::find($input['id']);
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
        $id = $request->get('id');
        $project = ProjectAvito::find($id);
        $avito = new AvitoApiComponent($project);
        $dataProjectFromAvito = $avito->loadInfoProject();
        $project->fill($dataProjectFromAvito)->save();
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
        $project = ProjectAvito::find($input['id']);
        $project->delete();
        return response()->json([
            "success" => true,
            "message" => "Проект успешно удален."
        ]);
    }
}