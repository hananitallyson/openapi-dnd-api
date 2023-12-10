<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateArmaRequest;
use App\Http\Resources\ArmasResource;
use App\Models\Arma;
use Illuminate\Http\Request;

class ArmasController extends Controller
{

    public function __construct()
    {
        $this->middleware('verifyTokenSuap')->only(['store', 'update', 'destroy']);
    }

    public function index()
    {
        $armas = Arma::all();

        return ArmasResource::collection($armas);
    }

    public function store(StoreUpdateArmaRequest $request)
    {
        //     if (!Auth::check()) {
        //         return response()->json(['message' => 'Você precisa estar autenticado para executar essa função', 403]);
        //     }
        if (empty($request->bearerToken())) {
            return response()->json(['message' => 'Token de acesso faltando ou inválido', 'status' => 401], 401);
        }

        $data = $request->validated();

        $arma = Arma::create($data);

        return new ArmasResource($arma);
    }

    public function show(string $index)
    {
        $armas = Arma::where('index', '=', $index)->first();

        if (!$armas) {
            return response()->json(['message' => 'Index não corresponde a nenhum resultado', 'status' => 404], 404);
        }

        return new ArmasResource($armas);
    }

    public function update(StoreUpdateArmaRequest $request, string $index)
    {
        // if (!Auth::check()) {
        //     return response()->json(['message' => 'Você precisa estar autenticado para executar essa função', 403]);
        // }

        if (empty($request->bearerToken())) {
            return response()->json(['message' => 'O usuário precisa estar autenticado', 'status' => 401], 401);
        }

        $armas = Arma::where('index', '=', $index)->first();

        if (!$armas) {
            return response()->json(['message' => 'Index não corresponde a nenhum resultado', 'status' => 404], 404);
        }

        $data = $request->validated();

        $armas->update($data);

        return new ArmasResource($armas);
    }

    public function destroy(string $index, Request $request)
    {
        // if (!Auth::check()) {
        //     return response()->json(['message' => 'Você precisa estar autenticado para executar essa função', 403]);
        // }

        if (empty($request->bearerToken())) {
            return response()->json(['message' => 'O usuário precisa estar autenticado', 'status' => 401], 401);
        }

        $armas = Arma::where('index', '=', $index)->first();

        if (!$armas) {
            return response()->json(['message' => 'Index não corresponde a nenhum resultado', 'status' => 404], 404);
        }

        $armas->delete();

        return response()->json(['message' => 'A arma foi deletada com sucesso', 'status' => 200], 200);
    }
}
