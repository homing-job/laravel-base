<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| ステートレスなルートはここに書く
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $_COOKIE;
});