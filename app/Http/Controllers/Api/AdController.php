<?php

namespace App\Http\Controllers\Api;

use App\Components\Avito\AvitoApiComponent;
use App\Http\Requests\adsRequest;
use App\Models\AdModel;
use App\Models\ProjectModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $ads = AdModel::all();
        return response()->json([
            "success" => true,
            "message" => "Объявления успешно загружены.",
            "data" => $ads
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, adsRequest $req): \Illuminate\Http\JsonResponse
    {
        $input = $request->all();
        $ad = new AdModel($input);
        $ad->save();
        return response()->json([
            "success" => true,
            "message" => "Объявление добавлено успешно."
        ]);
    }

    /**
     * Загрузка всех объявлений с Авито
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadAdsFromAvito(Request $request, adsRequest $req): \Illuminate\Http\JsonResponse
    {
        $project = ProjectModel::find($request->project_id);
        $avito = new AvitoApiComponent($project);
        $result = $avito->loadAds();
        return response()->json($result);
        if($result["success"] === false){
            return response()->json([
                "success" => false,
                "message" => $result["message"],
                "messageFromAvito" => $result["messageFromAvito"]
            ]);
        }
        return response()->json([
            "success" => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, adsRequest $req): \Illuminate\Http\JsonResponse
    {
        $input = $request->all();
        $ad = AdModel::find($input['id']);
        return response()->json([
            "success" => true,
            "message" => "Объявление успешно найдено.",
            "data" => $ad
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, adsRequest $req): \Illuminate\Http\JsonResponse
    {
        $input = $request->all();
        $ad = AdModel::find($input['id']);
        $ad->fill(request()->all())->save();
        return response()->json([
            "success" => true,
            "message" => "Объявление обновлено успешно."
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, adsRequest $req): \Illuminate\Http\JsonResponse
    {
        $input = $request->all();
        $ad = AdModel::find($input['id']);
        $ad->delete();
        return response()->json([
            "success" => true,
            "message" => "Объявление успешно удалено."
        ]);
    }
}
