<?php

use App\Http\Controllers\fileController;
use Illuminate\Support\Facades\Route;

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
    return view('dashboard');
});
Route::get('/cargar', function () {
    return view('loadFile');
});
Route::post('/cargar', [fileController::class, 'load'])->name('file.load');
Route::get('/ver', [fileController::class, 'download'])->name('file.download');
