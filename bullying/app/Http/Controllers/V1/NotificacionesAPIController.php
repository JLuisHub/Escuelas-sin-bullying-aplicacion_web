<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class NotificacionesAPIController extends Controller
{
    // Este método nos permite extraer las notificaciones de los alumnos vinculados a un tutor.
    public function getNotificaciones($id_tutor_legal){
        //Extrae los tutorados
        $tutorados = DB::table('estudiantes_tutores_legales')->where('id_tutor_legal',$id_tutor_legal)->get(); 
        $notificaciones = []; // Guardamos las notificaciones
        $cont =0 ;
        foreach($tutorados as $tutorado){
            $reporte = DB::table('reportes')->where('id_estudiante',$tutorado ->id_estudiante)->get(); // Extraemos los reportes
            foreach($reporte as $rep){
                //Generamos la notificación
                $not= array(
                    "id"=> $rep->id,
                    "asunto"=>"Reporte",
                    "fecha"=>$rep->fecha,
                    "descripcion"=> $rep->descripcion
                );
                $notificaciones[$cont]=$not;
                $cont+=1;
            }

            //Extraemos los citatorios del alumno
            $citatorio = DB::table('citatorios')->where('id_estudiante',$tutorado ->id_estudiante)->get();
            foreach($citatorio as $cit){
                //Generamos la notificación del citatorio
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

        //Regresamos la notificaciones
        return response() -> json($notificaciones);
    }


    //Extraemos las notificaciones de un solo alumno
    public function getNotificacionesAlumno($id){
        $notificaciones = [];
        //Extraemos los reportes del alumno
        $reporte = DB::table('reportes')->where('id_estudiante',$id)->get();
        $cont = 0;
        foreach($reporte as $rep){
            //Creamos la notificaciones del reporte
            $not= array(
                "id"=> $rep->id,
                "asunto"=>"Reporte",
                "fecha"=>$rep->fecha,
                "descripcion"=> $rep->descripcion
            );
            $notificaciones[$cont]=$not;
            $cont+=1;
        }

        // Extraemos los citatorios del alumno
        $citatorio = DB::table('citatorios')->where('id_estudiante',$id)->get();
        foreach($citatorio as $cit){
            //Generamos la notificacion del alumno del citatorio
            $not= array(
                "id"=> $cit->id,
                "asunto"=>"citatorio",
                "fecha"=>$cit->fecha,
                "descripcion"=> $cit->descripcion
            );
            $notificaciones[$cont]=$not;
            $cont+=1;
        }

        //Enviamos las notificaciones del alumno
        return response() -> json($notificaciones);
    }
}