<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\categoryRequest;
use App\Models\CategoryAvito;
use App\Jobs\JobAvitoAdsDownloading;
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
        $projects = CategoryAvito::all();
        return response()->json([
            "success" => true,
            "message" => "Категории успешно загружены.",
            "projects" => $projects
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, categoryRequest $req): \Illuminate\Http\JsonResponse
    {
        $input = $request->all();
        $project = new CategoryAvito($input);
        $project->save();
        return response()->json([
            "success" => true,
            "message" => "Категория добавлена успешно."
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, categoryRequest $req): \Illuminate\Http\JsonResponse
    {
        $input = $request->all();
        $project = CategoryAvito::find($input['id']);
        return response()->json([
            "success" => true,
            "message" => "Категория успешно найдена.",
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
    public function update(Request $request, categoryRequest $req): \Illuminate\Http\JsonResponse
    {
        $input = $request->all();
        $project = CategoryAvito::find($input['id']);
        $project->fill(request()->all())->save();
        return response()->json([
            "success" => true,
            "message" => "Категория обновлена успешно."
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, categoryRequest $req): \Illuminate\Http\JsonResponse
    {
        $input = $request->all();
        $project = CategoryAvito::find($input['id']);
        $project->delete();
        return response()->json([
            "success" => true,
            "message" => "Категория успешно удалена."
        ]);
    }
}
