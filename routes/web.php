<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/all-images', [ImageController::class, 'showAllImages']);

Route::get('/download-all-images', [ImageController::class, 'downloadAllImages']);

Route::get('/create', function() {
    return view('createImage');
});
Route::post('/create', [ImageController::class, 'create'])->name('image.create');

// Route::get('/change-name', [ImageController::class, 'changeName']);