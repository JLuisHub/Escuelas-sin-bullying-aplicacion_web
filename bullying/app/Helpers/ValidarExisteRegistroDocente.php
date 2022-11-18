<?php 
use Illuminate\Support\Facades\DB;

if( !function_exists('existe_docente')){
    
    function existe_docente($datos){
        $datos=DB::table('docentes')->where('Matricula',$datos[0])->where('clave',$datos[6])->get();
        if(empty($datos[0])){
            return false;
        }else{
            return true;
        }
    }
}

if( !function_exists('existe_correo')){
    
    function existe_correo($datos){
        $datos=DB::table('docentes')->where('email',$datos[5])->get();
        if(empty($datos[0])){
            return false;
        }else{
            return true;
        }
    }
}

if( !function_exists('pertenece_escuela')){
    
    function pertenece_escuela($datos){
        $clave_escuela = Auth::user()->clave;
        $clave_filtrada = explode("\n",$datos[6]);
        $clave_registrar =$clave_filtrada[0];
        if($clave_escuela == trim($clave_registrar)){
            return true;
        }else{
            return false;
        }
    }
}

?>