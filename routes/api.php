<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group(['prefix' => 'auth'], function () {
    Route::post('/sign-up', RegisterController::class)->name('auth.sign-up');
    Route::post('/sign-in', LoginController::class)->name('auth.sign-in');
});


Route::group([
        "middleware" => ["auth:sanctum", "role:admin"], 
        "prefix" => "admin", "as" => "admin."], function () {
    Route::apiResource("question", QuestionController::class);
});