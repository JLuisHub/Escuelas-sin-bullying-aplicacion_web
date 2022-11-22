<?php 
use Illuminate\Support\Facades\DB;

if( !function_exists('existe_estudiante')){
    function existe_estudiante($datos){
        $datos_existentes=DB::table('estudiantes')->where('Matricula',rtrim(ltrim($datos[0])))->where('clave',rtrim(ltrim($datos[5])))->get()->first();
        if(empty($datos_existentes) or $datos_existentes == null){
            return false;
        }else{
            return true;
        }
    }
}

if( !function_exists('pertenece_escuela_alumno')){
    
    function pertenece_escuela_alumno($datos){
        $clave_escuela = Auth::user()->clave;
        $clave_filtrada = explode("\n",$datos[5]);
        $clave_registrar =$clave_filtrada[0];
        if($clave_escuela == trim($clave_registrar)){
            return true;
        }else{
            return false;
        }
    }
}

?>