<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/meme/all', [App\Http\Controllers\ImageController::class, 'index']);

Route::get('/meme/id/{id}', [App\Http\Controllers\ImageController::class, 'getImageById']);

Route::get('/meme/page/{page}', [App\Http\Controllers\ImageController::class, 'getImageByPage']);

Route::get('/meme/popular', [App\Http\Controllers\ImageController::class, 'getMostPopularImage']);



// Route::get('/crawl-images', [App\Http\Controllers\Api\ImageAPIController::class, 'crawlImages']);