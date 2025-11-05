<?php

use App\Http\Controllers\CompteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::prefix('v1')->group(function () {
    Route::post('comptes', [CompteController::class, 'store']);
    Route::get('comptes', [CompteController::class, 'index']);
    // Route::get('comptes/{id}', [CompteController::class, 'show']);
    // Route::put('comptes/{id}', [CompteController::class, 'update']);
    // Route::delete('comptes/{id}', [CompteController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
