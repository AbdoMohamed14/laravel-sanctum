<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PostController;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
    
});


Route::post('/register', [UserController::class, 'register']);

Route::post('/login', [UserController::class, 'login']);


Route::middleware('auth:sanctum')->group( function () {

    Route::post('post/create', [PostController::class, 'store']);

    Route::get('post/unpublished', [PostController::class, 'unpublished_posts']);

    Route::post('post/publish', [PostController::class, 'post_publish']);

});

