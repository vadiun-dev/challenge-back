<?php

use Src\Application\Admin\User\Controllers\UserController;

Route::post('login', [\Src\Application\Admin\Auth\Controllers\AuthController::class, 'login']);
Route::post('forgot-password', [\Src\Application\Admin\Auth\Controllers\AuthController::class, 'forgotPassword'])->name('password.email');
Route::post('reset-password', [\Src\Application\Admin\Auth\Controllers\AuthController::class, 'resetPassword'])->name('password.reset');

Route::middleware(['auth:sanctum', 'verified', 'role:super_admin|admin'])->group(function (): void {

    //------------------------------ USERS -----------------------------

    Route::resource('users', UserController::class);

    //route
});
