<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Reporte;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;


class ReporteController extends Controller
{
    public function index()
    {
        $reportes = DB::table('reportes')
        ->join('docentes', 'reportes.id_docente', '=', 'docentes.id')
        ->where('docentes.clave', Auth::user()->clave)
        ->orderBy('fecha', 'desc')
        ->get();
        $contador = 0;
        $datos = [];
        foreach($reportes as $reporte){
            $estudiante = DB::table('estudiantes')->where('id', $reporte->id_estudiante)->get()->first();
            $reporteT= array(
                "Docente"=> $reporte->Nombre." ".$reporte->Apaterno." ".$reporte->Amaterno,
                "Alumno"=> $estudiante->Nombre." ".$estudiante->Apaterno." ".$estudiante->Amaterno,
                "Descripcion"=> $reporte->descripcion,
                "Fecha"=> $reporte->fecha
            );
            $datos[$contador]=$reporteT;
            $contador+=1;
        }
        $dato['titulo']='Reportes';
        $dato['tipo']='reportes';
        $dato['contenido']=$datos;
        $dato['cantidad']=count($datos);
        //return $dato['contenido'];
        return view('reporte_citatorio.plantilla', $dato);
    }

    public function busqueda(Request $request){
        $matricula = rtrim(ltrim($request->matricula));
        $docente = DB::table('docentes')
        ->where('Matricula', $matricula)
        ->where('clave', Auth::user()->clave)
        ->get()->first();
        if(empty($docente) or $docente == null){
            $estudiante = DB::table('estudiantes')->where('Matricula', $matricula)->where('clave', Auth::user()->clave)->get()->first();
            if(empty($estudiante) or $estudiante == null){
                return back()->withErrors([
                        'error' => "Esta matrícula no le pertenece a ningún docente ni estudiante."
                    ]);
            }else{
                $datos['reportes'] = DB::table('reportes')->where('id_estudiante', $estudiante->id)->orderBy('fecha', 'desc')
            ->join('docentes', 'reportes.id_docente', '=', 'docentes.id')
            ->get();
            $datos['cantidad']= count($datos['reportes']);
            $datos['url_enviada']= url('home');
            $datos['Alumno'] = $estudiante->Nombre." ".$estudiante->Apaterno." ".$estudiante->Amaterno;
            return view('estudiantes.reportes', $datos); 
            }

        }else{
            $datos['reportes'] = DB::table('reportes')->where('id_docente', $docente->id)->orderBy('fecha', 'desc')
            ->join('estudiantes', 'reportes.id_estudiante', '=', 'estudiantes.id')
            ->get();
            $datos['cantidad']= count($datos['reportes']);
            $datos['url_enviada']= url('home');
            $datos['docente'] = $docente->Nombre." ".$docente->Apaterno." ".$docente->Amaterno;
            return view('docentes.reportes', $datos);
        }
    }
}
