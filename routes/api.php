<?php

use App\Http\Controllers\QuizzesController;
use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('oauth')->get('/quizzes', [QuizzesController::class, 'index']);
Route::middleware('oauth')->get('/quizzes/{id}', [QuizzesController::class, 'show']);
Route::middleware('oauth')->post('/quizzes', [QuizzesController::class, 'create']);
Route::middleware('oauth')->put('/quizzes/{id}', [QuizzesController::class, 'change']);
Route::middleware('oauth')->delete('/quizzes/{id}', [QuizzesController::class, 'delete']);

Route::middleware('oauth')->get('/profile', function (Request $request) {
    return response()->json($request->user());
});
