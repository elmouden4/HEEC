<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SignalController;
use App\Http\Controllers\PointController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes d'authentification API
Route::post('/login', [AuthController::class, 'apiLogin']);
Route::post('/register', [AuthController::class, 'apiRegister']);
Route::post('/logout', [AuthController::class, 'apiLogout'])->middleware('auth:sanctum');

// Routes pour les points (publiques)
Route::post('/points/add', [PointController::class, 'addPoints']);
Route::get('/points/user/{userId}', [PointController::class, 'getUserScore']);
Route::get('/points/leaderboard', [PointController::class, 'getAllScores']);

// Routes protégées par API
Route::middleware('auth:sanctum')->group(function () {
    // Routes pour les incidents
    Route::post('/signal', [SignalController::class, 'store']);
    Route::get('/incidents', [SignalController::class, 'index']);
    Route::get('/incidents/{id}', [SignalController::class, 'show']);
    Route::put('/incidents/{id}', [SignalController::class, 'update']);
    Route::delete('/incidents/{id}', [SignalController::class, 'destroy']);

    // Routes pour les points (protégées)
    Route::get('/points/my-score', [PointController::class, 'getMyScore']);
    Route::post('/points/reset', [PointController::class, 'resetScore']);
});
