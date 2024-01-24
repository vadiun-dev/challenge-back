<?php

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

use Illuminate\Support\Facades\Route;

Route::post('login', 'Src\Application\Admin\Auth\Controllers\AuthController@login');

Route::middleware(['auth:sanctum', 'verified'])->group(function (): void {

    //------------------------------ USERS -----------------------------

    Route::get('obtener-posteos', 'App\Http\Controllers\BlogController@index');
    Route::get('posteo/{id}', 'App\Http\Controllers\BlogController@show');
    Route::post('crear-posteo', 'App\Http\Controllers\BlogController@createPost');

    Route::post('crear-like/{postId}', 'App\Http\Controllers\BlogController@addLike');
    //route
});
