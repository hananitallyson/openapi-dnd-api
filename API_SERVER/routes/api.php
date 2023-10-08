<?php

use App\Http\Controllers\Api\ArmasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Yaml\Yaml;

Route::get('/', function(){
    $archive = file_get_contents('../../openapi.yml');
    $data = Yaml::parse($archive);
    return response()->json($data);
});

Route::get('/armas', [ArmasController::class, 'index']);
Route::post('/armas',[ArmasController::class, 'store']);
Route::get('/armas/{index}',[ArmasController::class, 'show']);