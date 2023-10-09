<?php

use App\Http\Controllers\Api\ArmasController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Yaml\Yaml;

Route::get('/api', function(){
    $archive = file_get_contents('../../openapi.yml');
    $data = Yaml::parse($archive);
    return response()->json($data);
});

Route::apiResource('/api/armas', ArmasController::class);