<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
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

Route::post('v1/user', [UserController::class, 'create']);
Route::post('login', [UserController::class, 'login']);
Route::prefix('/v1')->middleware('auth:api')->group(function () {
    Route::get('/users/show', [UserController::class, 'show']); 
    Route::get('/users/show_specific/{id}', [UserController::class, 'show_specific']); 
    Route::put('/users/update/{id}', [UserController::class, 'update']);
    Route::delete('/users/delete/{id}', [UserController::class, 'delete']);
});
