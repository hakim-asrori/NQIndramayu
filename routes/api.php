<?php

use App\Http\Controllers\API\DoaCategoryController;
use App\Http\Controllers\API\DoaController;
use App\Http\Controllers\API\MaulidController;
use App\Http\Controllers\API\SholawatController;
use App\Http\Controllers\API\VideoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('videos', [VideoController::class, 'index']);
Route::get('sholawats', [SholawatController::class, 'index']);
Route::get('maulids', [MaulidController::class, 'index']);
Route::get('doa', [DoaController::class, 'index']);
Route::get('doa-categories', [DoaCategoryController::class, 'index']);
