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

Route::get('/', function () {
    return view('main.index');
})->name('main.index');

Route::get('/input', function () {
    return view('components.input');
});
Route::post('/input', [App\Http\Controllers\InputController::class, 'upload'])->name('input.upload');

Route::get('/daily', [LogController::class, 'daily'])->name('logs.daily');
Route::get('/weekly', [LogController::class, 'weekly'])->name('logs.weekly');
Route::get('/monthly', [LogController::class, 'monthly'])->name('logs.monthly');
