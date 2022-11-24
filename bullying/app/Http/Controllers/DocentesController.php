<?php

namespace App\Http\Controllers;

use App\Models\Docentes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Hash;


class DocentesController extends Controller
{
    /**
     * Muestra la vista para que el directivo registre docentes.
     */
    public function index()
    {
        // Comprueba si el usuario esta logeado
        if(!Auth::check()){
            return view('auth.login');
        }

        //  Obtiene los docentes que ya han sido registrados en la escuela.
        $datos['docentes'] = DB::table('docentes')
        ->where('clave', Auth::user()->clave)
        ->paginate(10);
        
        // Envia la lista de docentes a la vista docentes.lista
        return view('docentes.lista', $datos);
    }

    /**
     * Muestra la vista donde el directivo selecciona el archivo CSV
     * para registrar a los docentes.
     */
    public function create()
    {
        // Comprueba si el usuario esta logeado
        if(!Auth::check()){
            return view('auth.login');
        }

        // Hace llamar al template para registrar docentes
        return view('docentes.reg_docentes');
    }

     /**
     * Nos permite la importación de los datos de un archivo
     **/
    public function store(Request $request)
    {
        
        //  Comprueba si el usuario esta logeado
        if(!Auth::check()){
            return view('auth.login');
        }
        //  Valida que el archivo que selecionó el directivo sea un archivo CSV.
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt'
        ]);

        //  Si el archivo selecionado no es CSV se mostrará un mensaje de error.
        if ($validator->fails()) {
            return back()->withErrors([
                'error'=>
                'El archivo seleccionado no es un archivo con extensión CSV. Por favor, seleccione un archivo nuevamente.'
            ]);
        }

        $archivoCSV = file($request->file->getRealPath()); 
        $filas = array_slice($archivoCSV,1); // Nos permite eliminar la primera linea del archivo
        $filasLimpias =[];
        $numFilas = count($filas);
        $numFilaActual = 2;

        if($numFilas == 0){
            return back()->withErrors([
                'error' => "El archivo proporcionado está vacío."
            ]);
        }

        foreach($filas as $filaActual){
            // Cada fila la separamos por columnas
            $columnasFilaActual = explode(",",$filaActual);

            if( count($columnasFilaActual) < 7 ){
                return back()->withErrors([
                    'error' => "El archivo proporcionado contiene menos de 7 columnas"
                ]);
            }else{ // El archivo contiene 7 o más columnas

                $numColumnasVacias = 0;
                $numColumnasConDatos = 0;
                $numero_col = 0;

                // Recorremos las primeras 7 columnas de la fila actual.
                // y cuenta el número de columnas vacias y columnas con datos.
                foreach($columnasFilaActual as $columnaActualFilaActual){
                    if($numero_col==7){
                        break;
                    }
                    if( rtrim(ltrim($columnaActualFilaActual)) == "" ){
                        $numColumnasVacias += 1;
                    }else{
                        $numColumnasConDatos += 1;
                    }
                    $numero_col += 1;
                }

                if($numColumnasVacias<7){ // es una fila que puede contener columnas vacias

                    if( rtrim(ltrim($columnasFilaActual[6])) != Auth::user()->clave ){
                        return back()->withErrors([
                            'error' => "En la fila " . $numFilaActual . " la clave de la escuela en el archivo no es la misma a la de usted."
                        ]);
                    }
    
                    if( $numColumnasConDatos >= 1 && $numColumnasVacias >= 1 ){
                        return back()->withErrors([
                            'error' => "En la fila " . $numFilaActual . " hay columnas vacías, revise que todos los datos esten completos e intente nuevamente."
                        ]);
                    }
                    

                    if(existe_docente($columnasFilaActual) || existe_correo($columnasFilaActual)){
                        return back()->withErrors([
                            'error' => "En la fila " . $numFilaActual . " ese la matícula o el correo del docente ya esta registrado."
                        ]);
                    }
    
                    if($numColumnasConDatos==7 && $numColumnasVacias==0){
                        array_push($filasLimpias,$columnasFilaActual);
                    }

                }                
            }

            $numFilaActual += 1;
        }


        $mensaje = (new Docentes())->guardarDocentes($filasLimpias);
        return back()->withErrors([
            'error' => $mensaje
        ]);

        /*
        if($tamanio!=0){
            for($i=0; $i<$tamanio; $i++){
                $dato = $data[$i];
                $columnas = explode(",",$dato);
                $tam = count($columnas);
                $bol = False;
                $contador = 0;
                for($j=0; $j<$tam; $j++){
                    if(ltrim(rtrim($columnas[$j])=="")){
                        $bol = true;
                        $contador +=1;
                    }
                }
                if($bol and $contador==7){
                    //no se hace nada
                }else if($bol and $contador <7){
                    return back()->withErrors([
                        'error' => "Hay columnas vacías en los registros, revise que todos los datos esten completos e intente nuevamente."
                    ]);
                }else{
                    if(!existe_docente($columnas) and !existe_correo($columnas)){
                        if(pertenece_escuela($columnas)){
                            $datos[$i]=$columnas;
                        }else{
                            return back()->withErrors([
                                'error' => "La clave de la escuela no es la misma a la de usted."
                            ]);
                        }
                    }else{
                        return back()->withErrors([
                            'error' => "Hay registros ya existentes."
                        ]);
                    }
                }
            }
        }else{
            return back()->withErrors([
                'error' => "El archivo ingresado no contiene registros."
            ]);
        }

        dd($datos);

        $mensaje = (new Docentes())->guardarDocentes($datos);
        return back()->withErrors([
            'error' => $mensaje
        ]);

        */


    }
    
    /**
     * Nos permite mostrar los reportes que ha generado el docente en particular
     *
     * @param  \App\Models\Docentes  $docentes
     * @return \Illuminate\Http\Response
     */
    public function show($id_docente)
    {
        $docente = DB::table('docentes')->where('id', $id_docente)->get()->first();
        if($docente->clave == Auth::user()->clave){
            $datos['reportes'] = DB::table('reportes')->where('id_docente', $id_docente)->orderBy('fecha', 'desc')
            ->join('estudiantes', 'reportes.id_estudiante', '=', 'estudiantes.id')
            ->get();
            $datos['cantidad']= count($datos['reportes']);
            $datos['url_enviada']= url('docentes');
            $datos['docente'] = $docente->Nombre." ".$docente->Apaterno." ".$docente->Amaterno;
            return view('docentes.reportes', $datos);
        }else{
            return "Error";
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Docentes  $docentes
     * @return \Illuminate\Http\Response
     */
    public function edit(Docentes $docentes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Docentes  $docentes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Docentes $docentes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Docentes  $docentes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Docentes $docentes)
    {
        //
    }
}
