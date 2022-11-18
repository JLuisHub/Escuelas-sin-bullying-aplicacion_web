<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\DocentesAPIController;
use App\Http\Controllers\V1\ReporteAPIController; 
use App\Http\Controllers\V1\EstudianteAPIController;
use App\Http\Controllers\V1\CitatorioAPIController;
use App\Http\Controllers\V1\AuthDocenteController;
use App\Http\Controllers\V1\AuthTutorLegalController;
use App\Http\Controllers\V1\TutorLegalAPIController;
use App\Http\Controllers\V1\NotificacionesAPIController;
use App\Http\Controllers\V1\AuthTutorLegalAndDocenteController;


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

// PARTE DE REYNA 
Route::group(["auth:sanctum"],function(){
    
    Route::get('estudiantes/{clave}',[EstudianteAPIController::class,'showAll']); // Pendiente

});

Route::get('reporte_detalle/{id}',[ReporteAPIController::class,'showReporte']); // Pendiente 


Route::prefix('v1')->group(function () {

    // RUTAS DOCENTE
    Route::post('docente/login', [AuthDocenteController::class, 'authenticate']);

    Route::post('docente/logout', [AuthDocenteController::class, 'logout']);
    Route::post('docente/citatorio', [CitatorioAPIController::class, 'store']);

    Route::post("docente/reporte", [ReporteAPIController::class,'store'] );
    Route::put("docente/cambio_contrasenia", [DocentesAPIController::class,'cambiarContrasenia'] );
    Route::delete("docente/reporte/{id_reporte}",[ReporteAPIController::class,'destroy']);

    Route::get('reportes/estudiante/{id}',[ReporteAPIController::class,'showEstudiante']); // pendiente



    // RUTAS TUTOR LEGAL
    Route::post('tutor_legal/register', [AuthTutorLegalController::class, 'register']);
    Route::post('tutor_legal/logout', [AuthTutorLegalController::class, 'logout']);
    Route::get('tutor_legal/citatorio_detalle/{id}',[CitatorioAPIController::class,'showCitatorio']);
    Route::get('tutor_legal/notificaciones/{id_tutor_legal}',[NotificacionesAPIController::class,'getNotificaciones']);
    Route::get('tutor_legal/notificacionesA/{id}',[NotificacionesAPIController::class,'getNotificacionesAlumno']);
    Route::post("tutor_legal/vincular", [TutorLegalAPIController::class,'store'] );
    Route::post('tutor_legal_docente/login', [AuthTutorLegalAndDocenteController::class, 'authenticate']);
    Route::get("tutor_legal/tutorados/{id_tutor_legal}", [TutorLegalAPIController::class,'showAll'] );


    Route::prefix('v1')->group(function () {

        Route::post('citatorio', [CitatorioAPIController::class, 'store']);


        Route::post('login', [AuthController::class, 'authenticate']);
        //Todas las rutas aqui dentro requieren autenticación
        Route::group(['middleware' => ['jwt.verify']], function() {
            Route::post('logout', [AuthController::class, 'logout']);
            Route::post('get-user', [AuthController::class, 'getUser']);
            Route::get('docentes', [DocentesAPIController::class, 'index']);
            Route::get('docentes/{clave}', [DocentesAPIController::class, 'show']);
        });
    });

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });


});
