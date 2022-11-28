<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AgendaController as Agenda;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('agenda')->group(function () {
    Route::post('/guardar', [Agenda::class,'GuardarAgenda']);
    Route::get('/listar/{id}', [Agenda::class,'ListarAgenda']);
    Route::delete('/eliminar/{id}', [Agenda::class,'EliminarAgenda']);
});
