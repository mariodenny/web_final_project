<?php

use App\Http\Controllers\Api\PlantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::apiResource('plants', PlantController::class);
    // route for update plant using POST because i have image to update also
    Route::post('/plants/{id}', [PlantController::class, 'updatePlants']);
});
