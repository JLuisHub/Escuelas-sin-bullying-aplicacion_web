<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reporte;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Citatorio;
use App\Models\Estudiantes;
use App\Models\Docentes;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CitatorioController extends Controller
{


    public function index()
    {
        $citatorios = DB::table('citatorios')
        ->join('docentes', 'citatorios.id_docente', '=', 'docentes.id')
        ->where('docentes.clave', Auth::user()->clave)
        ->orderBy('fecha', 'desc')
        ->get();
        $contador = 0;
        $datos = [];
        foreach($citatorios as $citatorio){
            $estudiante = DB::table('estudiantes')->where('id', $citatorio->id_estudiante)->get()->first();
            $citatorioT= array(
                "Docente"=> $citatorio->Nombre." ".$citatorio->Apaterno." ".$citatorio->Amaterno,
                "Alumno"=> $estudiante->Nombre." ".$estudiante->Apaterno." ".$estudiante->Amaterno,
                "Descripcion"=> $citatorio->descripcion,
                "Fecha"=> $citatorio->fecha
            );
            $datos[$contador]=$citatorioT;
            $contador+=1;
        }
        $dato['titulo']='Citatorios';
        $dato['tipo']='citatorios';
        $dato['contenido']=$datos;
        $dato['cantidad']=count($datos);
        //return $dato['contenido'];
        return view('reporte_citatorio.plantilla', $dato);
    }
    
}
