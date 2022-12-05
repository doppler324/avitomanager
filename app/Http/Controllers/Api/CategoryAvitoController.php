<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\projectRequest;
use App\Models\CategoryAvito;
use App\Jobs\JobAvitoAdsDownloading;
use App\Models\ProjectAvito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryAvitoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $projects = CategoryAvito::where('user_id', Auth::id())->get();
        return response()->json([
            "success" => true,
            "message" => "Проекты успешно загружены.",
            "projects" => $projects
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
        $project = new CategoryAvito($input);
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
    public function show(Request $request, projectRequest $req): \Illuminate\Http\JsonResponse
    {
        $input = $request->all();
        $project = CategoryAvito::find($input['id']);
        return response()->json([
            "success" => true,
            "message" => "Проект успешно найден.",
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
    public function update(Request $request, projectRequest $req): \Illuminate\Http\JsonResponse
    {
        $input = $request->all();
        $project = CategoryAvito::find($input['id']);
        $project->fill(request()->all())->save();
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
        $project = CategoryAvito::find($input['id']);
        $project->delete();
        return response()->json([
            "success" => true,
            "message" => "Проект успешно удален."
        ]);
    }
}
