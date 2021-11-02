<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\TagController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//Route::group(['namespace' => 'API'], function () {

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register'])->middleware('digits-to-en');
    Route::post('login', [AuthController::class, 'login'])->middleware('digits-to-en');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', [AuthController::class, 'logout']);
    });
});


Route::get('salam', [PostController::class, 'index']);
Route::get('salam2', [TagController::class, 'index']);

Route::group(['middleware' => ['auth:api']], function () {

});
//});
