<?php

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/curso', [App\Http\Controllers\CursoController::class, 'index'])->name('curso');
Route::post('/curso', [App\Http\Controllers\CursoController::class, 'store']);
Route::put('/curso', [App\Http\Controllers\CursoController::class, 'update']);
Route::delete('/curso', [App\Http\Controllers\CursoController::class, 'destroy']);

Route::get('/turma', [App\Http\Controllers\TurmaController::class, 'index'])->name('turma');
Route::post('/turma', [App\Http\Controllers\TurmaController::class, 'store']);
Route::put('/turma', [App\Http\Controllers\TurmaController::class, 'update']);
Route::delete('/turma', [App\Http\Controllers\TurmaController::class, 'destroy']);

Route::get('/participante', [App\Http\Controllers\ParticipanteController::class, 'index'])->name('participante');
Route::post('/participante', [App\Http\Controllers\ParticipanteController::class, 'store']);
Route::put('/participante', [App\Http\Controllers\ParticipanteController::class, 'update']);
Route::delete('/participante', [App\Http\Controllers\ParticipanteController::class, 'destroy']);

Route::get('/sala', [App\Http\Controllers\SalaController::class, 'index'])->name('sala');
Route::post('/sala', [App\Http\Controllers\SalaController::class, 'store']);
Route::put('/sala', [App\Http\Controllers\SalaController::class, 'update']);
Route::delete('/sala', [App\Http\Controllers\SalaController::class, 'destroy']);

Route::get('/prova', [App\Http\Controllers\ProvaController::class, 'index'])->name('prova');
Route::post('/prova', [App\Http\Controllers\ProvaController::class, 'store']);
Route::put('/prova', [App\Http\Controllers\ProvaController::class, 'update']);
Route::delete('/prova', [App\Http\Controllers\ProvaController::class, 'destroy']);

Route::get('/planilha', [App\Http\Controllers\PlanilhaController::class, 'index'])->name('planilha');
Route::post('/planilha', [App\Http\Controllers\PlanilhaController::class, 'processarPlanilha']);

Route::get('/gerador', [App\Http\Controllers\GeradorController::class, 'index'])->name('gerador');


