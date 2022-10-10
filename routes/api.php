<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::controller(AuthController::class)->group(function(){
//     Route::post('login', 'login');
//     Route::post('register', 'register');
//     Route::post('logout', 'logout');
//     Route::post('refresh', 'refresh');
// });

// Route::controller(TodoController::class)->group(function () {
//     Route::get('todo', 'index');
//     Route::post('todo', 'store');
//     Route::put('todo/{id}', 'update');
//     Route::delete('todo/{id}', 'destroy');
// });

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::get('todo', [TodoController::class, 'index']);
    Route::post('todo', [TodoController::class, 'store']);
    Route::put('todo/{id}', [TodoController::class, 'update']);
    Route::delete('todo/{id}', [TodoController::class, 'destroy']);
});
