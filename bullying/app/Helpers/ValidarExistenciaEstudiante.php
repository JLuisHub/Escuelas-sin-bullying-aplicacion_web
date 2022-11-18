<?php 
use Illuminate\Support\Facades\DB;

if( !function_exists('existe_estudiante')){
    function existe_estudiante($datos){
        $datos_existentes=DB::table('estudiantes')->where('Matricula',rtrim(ltrim($datos[0])))->where('clave',rtrim(ltrim($datos[6])))->get()->first();
        if(empty($datos_existentes) or $datos_existentes == null){
            return false;
        }else{
            return true;
        }
    }
}

?>