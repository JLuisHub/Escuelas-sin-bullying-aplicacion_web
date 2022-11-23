<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class NotificacionesAPIController extends Controller
{
    public function getNotificaciones($id_tutor_legal){
        // Se obtienen los tutorados del tutor legal pasado por parametro
        $tutorados = DB::table('estudiantes_tutores_legales')->where('id_tutor_legal',$id_tutor_legal)->get(); 
        $notificaciones = [];
        $cont =0 ;
        foreach($tutorados as $tutorado){
            // De cada tutorado extaigo sus reportes y los guardo en notificaciones
            $reporte = DB::table('reportes')->where('id_estudiante',$tutorado ->id_estudiante)->get();
            foreach($reporte as $rep){
                $not= array(
                    "id"=> $rep->id,
                    "asunto"=>"Reporte",
                    "fecha"=>$rep->fecha,
                    "descripcion"=> $rep->descripcion
                );
                $notificaciones[$cont]=$not;
                $cont+=1;
            }

            // De cada tutorado extraigo sus citatorios y los guardo en notificaciones.
            $citatorio = DB::table('citatorios')->where('id_estudiante',$tutorado ->id_estudiante)->get();
            foreach($citatorio as $cit){
                $not= array(
                    "id"=> $cit->id,
                    "asunto"=>"citatorio",
                    "fecha"=>$cit->fecha,
                    "descripcion"=> $cit->descripcion
                );
                $notificaciones[$cont]=$not;
                $cont+=1;
            }
        }
        return response() -> json($notificaciones);
    }

    public function getNotificacionesReporte($id){
        // Valido que el id pasado por parámetro sea valido
        if($id==null){
            return response()->json([
                    'message' => 'Ha surgido un error, no se pueden obtener las notificaciones.',
                ], 400);
        }

        // Valido que el alumno exista, es deicr, que en la base de datos exista
        // un alumno con el ID pasado por parámetro.
        $estudiante = DB::table('estudiantes')->where('id',$id)->get();
        if(empty($estudiante[0]) or $estudiante== null){
            return response()->json([
                    'message' => 'El alumno no se encuentra registrado.',
                ], 400);
        }

        // Obtengo los reportes de ese alumno y se guardan en el arreglo de notificaciones
        $notificaciones = [];
        $reporte = DB::table('reportes')->where('id_estudiante',$id)->get();
        $cont = 0;
        foreach($reporte as $rep){
            $not= array(
                "id"=> $rep->id,
                "asunto"=>"Reporte",
                "fecha"=>$rep->fecha,
                "descripcion"=> $rep->descripcion
            );
            $notificaciones[$cont]=$not;
            $cont+=1;
        }
        return response() -> json($notificaciones);
    }


    public function getNotificacionesCitatorio($id){
        // Valido que el id pasado por parámetro sea valido
        if($id==null){
            return response()->json([
                    'message' => 'Ha surgido un error, no se pueden obtener las notificaciones.',
                ], 400);
        }
        // Valido que el alumno exista, es deicr, que en la base de datos exista
        // un alumno con el ID pasado por parámetro.
        $estudiante = DB::table('estudiantes')->where('id',$id)->get();
        if(empty($estudiante[0]) or $estudiante== null){
            return response()->json([
                    'message' => 'El alumno no se encuentra registrado.',
                ], 400);
        }

        // Obtengo los citatorios de ese alumno y se guardan en el arreglo de notificaciones
        $notificaciones = [];
        $cont = 0;
        $citatorio = DB::table('citatorios')->where('id_estudiante',$id)->get();
        foreach($citatorio as $cit){
            $not= array(
                "id"=> $cit->id,
                "asunto"=>"citatorio",
                "fecha"=>$cit->fecha,
                "descripcion"=> $cit->descripcion
            );
            $notificaciones[$cont]=$not;
            $cont+=1;
        }
        return response() -> json($notificaciones);
    }
}