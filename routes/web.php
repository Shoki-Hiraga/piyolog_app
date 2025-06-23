<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InputController;
use App\Http\Controllers\LogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/input', function () {
    return view('main.input');
});

Route::post('/input', [App\Http\Controllers\InputController::class, 'upload'])->name('input.upload');
Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
