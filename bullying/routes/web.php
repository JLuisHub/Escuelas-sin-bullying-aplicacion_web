<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstudiantesController;
use App\Http\Controllers\DocentesController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\V1\AuthTutorLegalController;
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
    return view('auth.login');
});



Auth::routes();

Route::get('/verAlumnos', function () {
    return view('verAlumnos');
});
// rutas para las vistas
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('docentes','App\Http\Controllers\DocentesController');
Route::resource('estudiantes','App\Http\Controllers\EstudiantesController');
Route::resource('reportes','App\Http\Controllers\ReporteController');
Route::resource('citatorios','App\Http\Controllers\CitatorioController');
Route::resource('docentes/reportes','App\Http\Controllers\DocentesController');

// Ruta para mostrar la pagina de registro al tutor legal


Route::resource('tutor_legal/registro', 'App\Http\Controllers\V1\AuthTutorLegalController');

Route::get('docentes/reportes/{id}',[DocentesController::class,'show']);
Route::get('estudiantes/reportes/{id}',[EstudiantesController::class,'show']);
Route::get('docentes/eliminar/{id}',[DocentesController::class,'destroy']);
Route::get('estudiantes/eliminar/{id}',[EstudiantesController::class,'destroy']);
Route::resource('estudiantes','App\Http\Controllers\EstudiantesController');
Route::get('busqueda', [ReporteController::class, 'busqueda']);
