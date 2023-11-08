<?php

use App\Http\Controllers\Api\ArmasController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/api', function () {

    $user = User::find(1);

    if (!$user) {
        $user = User::factory(1)->create();
    }

    Auth::login($user);
});

Route::apiResource('/api/armas', ArmasController::class);
