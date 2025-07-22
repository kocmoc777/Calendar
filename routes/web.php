<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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
Route::get('/',function (){
    return redirect('/home');
});
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/calendar', [EventController::class, '__invoke'])->name('index');     // Отримати одну подію
Route::get('/events/{id}', [EventController::class, 'show'])->name('show');     // Отримати одну подію
Route::post('/event/store', [EventController::class, 'store']);
Route::post('/events/{id}', [EventController::class, 'update'])->name('update'); // Оновити подію
Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('destroy'); // Видалити подію





Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
