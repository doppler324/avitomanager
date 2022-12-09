<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\categoryRequest;
use App\Models\CategoryModel;
use App\Jobs\JobAvitoAdsDownloading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $categories = CategoryModel::all();
        return response()->json([
            "success" => true,
            "message" => "Категории успешно загружены.",
            "data" => $categories
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
        $category = new CategoryModel($input);
        $category->save();
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
        $category = CategoryModel::find($input['id']);
        return response()->json([
            "success" => true,
            "message" => "Категория успешно найдена.",
            "data" => $category
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
        $category = CategoryModel::find($input['id']);
        $category->fill(request()->all())->save();
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
        $category = CategoryModel::find($input['id']);
        $category->delete();
        return response()->json([
            "success" => true,
            "message" => "Категория успешно удалена."
        ]);
    }
}
