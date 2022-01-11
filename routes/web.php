<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;


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
    return redirect('login');
});

Route::get('/login', function () {
    return view('login');
})->name('login');
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
});

Route::get('/upload', function () {
    return view('upload');
})->middleware('auth');

Route::post('/upload-file', [UploadController::class, 'uploadFile'])->middleware('auth');
Route::post('/authenticate', [AuthController::class, 'authenticate']);
