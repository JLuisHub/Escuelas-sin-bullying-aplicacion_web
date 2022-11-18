<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class NotificacionesAPIController extends Controller
{
    public function getNotificaciones($id_tutor_legal){
        $tutorados = DB::table('estudiantes_tutores_legales')->where('id_tutor_legal',$id_tutor_legal)->get(); 
        $notificaciones = [];
        $cont =0 ;
        foreach($tutorados as $tutorado){
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

    public function getNotificacionesAlumno($id){
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