<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\adsRequest;
use App\Models\AdAvito;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdAvitoApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $ads = AdAvito::all();
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
        $ad = new AdAvito($input);
        $ad->save();
        return response()->json([
            "success" => true,
            "message" => "Объявление добавлено успешно."
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
        $ad = AdAvito::find($input['id']);
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
        $ad = AdAvito::find($input['id']);
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
        $ad = AdAvito::find($input['id']);
        $ad->delete();
        return response()->json([
            "success" => true,
            "message" => "Объявление успешно удалено."
        ]);
    }
}
