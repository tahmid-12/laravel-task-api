<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    Route::get('/tasks', [TaskController::class, 'index']);         // Get all tasks
    Route::post('/tasks', [TaskController::class, 'store']);        // Create a task
    Route::get('/tasks/{id}', [TaskController::class, 'show']);     // Get a single task by ID
    Route::put('/tasks/{id}', [TaskController::class, 'update']);   // Update a task
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
