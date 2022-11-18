<?php 
use Illuminate\Support\Facades\DB;

if( !function_exists('validar_estructura_del_archivo')){
    
    function validar_estructura_del_archivo($renglones,$numero_de_filas, $tipo){

        if( empty($renglones) ){ // No hay renglones por agregar.
            return "El archivo proporcionado no contiene datos.";
        }

        $mensaje_de_error = "";

        $contiene_cols_vacias = false;
        $es_la_clave_congruente = true;

        $numero_renglon = 2; // Esta variable nos ayuda a detectar en que renglón del archivo CSV se dio un error.
        $clave_erronea = "";
        $num_col_err = 0;


        // Recorre cada una de las filas del archivo CSV, exepto el primero ya que este es la cabecera del archivo
        for( $pos_renglon=1; $pos_renglon<$numero_de_filas; $pos_renglon++ ){

            $renglon_actual = $renglones[$pos_renglon];
            // Divido el renglón acutal o fila por ,
            // Renglon dividido contiene el contenido en texto de cada una de las columnas del archivo CSV
            $renglon_dividido = explode(",",$renglon_actual);

            if( count($renglon_dividido) < 7){
                $contiene_cols_vacias = true;
                break;
            }

            $num_col_err = 0;
            //  Verificamos que las columnas no esten vacias.
            for( $num_col=0; $num_col<7; $num_col++ ){

                $columna_actual = $renglon_dividido[$num_col];
                $num_col_err = $num_col_err + 1;

                if( empty( rtrim( ltrim($columna_actual) ) ) ){ // Se encontró una columna vacía
                    $contiene_cols_vacias = true;
                    break;
                }

            }
            
            // Recordemos que cada fila el archivo CSV debe de tener 7 columnas
            if( $contiene_cols_vacias ){
                $contiene_cols_vacias = true;
                break;
            }

            //  Valida que la clave del director sea igual que la clave de los alumnos del archivo CSV
            //  Ejemplo: Supongamos que la clave del director es: 1324JFB123 y en el archivo CSV tenemos
            //  un registro con clave de institución  HGFBB1234. En este caso no deberia de ser posible para
            //  el director subir el archivo CSV.
            if(  rtrim((ltrim($renglon_dividido[6]))) != Auth::user()->clave  ){ 
                $es_la_clave_congruente = false;
                $clave_erronea = rtrim(ltrim($renglon_dividido[6]));
                break;
            }

            $datos_existentes = "";
            $docente_existente_correo = "";
            if($tipo == "docentes"){
                $datos_existentes = DB::table('docentes')->where('Matricula',$renglon_dividido[0])->where('clave',Auth::user()->clave)->get();
                $docente_existente_correo = DB::table('docentes')->where('email',$renglon_dividido[5])->get();
            }else{
                $datos_existentes = DB::table('estudiantes')->where('Matricula',$renglon_dividido[0])->where('clave',Auth::user()->clave)->get();
            }

            if( !empty($datos_existentes[0]) || !empty($docente_existente_correo[0]) ){
                $mensaje_de_error = "Ya se encuentran registros existentes. Compruebe que nadie este registrado e intente nuevamente.";
                break;
            }

            $numero_renglon = $numero_renglon + 1;
            
        }

        if( $contiene_cols_vacias ){
            $mensaje_de_error = 'En la fila ' . $numero_renglon . ' la columna ' . $num_col_err .' esta vacía. ';
        }

        if( $es_la_clave_congruente == false ){
            if( empty(trim($clave_erronea)) ){
                $clave_erronea = "Columna vacía.";
            }

            $mensaje_de_error = 'En la fila ' . $numero_renglon . ' del archivo CSV, la clave de institución 
            no es congruente con la clave de tú institución. Tú clave es :' . Auth::user()->clave . ' y la clave en el archivo CSV es '
            . $clave_erronea;
        }

        return $mensaje_de_error;

    }
}

?>