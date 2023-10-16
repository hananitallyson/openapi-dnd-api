<?php

use App\Http\Controllers\Api\ArmasController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {

    $user = User::find(1);

    if (!$user) {
        $user = User::factory(1)->create();
    }

    Auth::login($user);

    return redirect('/armas');
});

Route::apiResource('/armas', ArmasController::class);
