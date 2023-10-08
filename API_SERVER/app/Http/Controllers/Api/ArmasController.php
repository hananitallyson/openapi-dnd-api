<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArmasResource;
use App\Models\Arma;
use Illuminate\Http\Request;

class ArmasController extends Controller
{
    public function index(){

        $armas = Arma::all();
        
        return ArmasResource::collection($armas);
    }
}
