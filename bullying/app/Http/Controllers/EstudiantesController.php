<?php

namespace App\Http\Controllers;

use App\Models\Estudiantes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class EstudiantesController extends Controller
{
    /**
     * Muestra la vista para que el directivo registre alumnos.
     **/
    public function index()
    {
        // Comprueba si el usuario esta logeado
        if(!Auth::check()){
            return view('auth.login');
        }
        
        //  Obtiene los alumnos que ya han sido registrados en la escuela.
        $datos['estudiantes']=DB::table('estudiantes')
        ->where('clave', Auth::user()->clave)
        ->paginate(10);

        //  Envia la lista de estudiantes a la vista estudiantes.lista
        return view('estudiantes.lista', $datos);
    }

    /**
     * Muestra la vista donde el directivo selecciona el archivo CSV
     * para registrar a los alumnos.
     */
    public function create()
    {
        //// Comprueba si el usuario esta logeado
        if(!Auth::check()){
            return view('auth.login');
        }

         // Hace llamar al template para registrar estudiantes (get)
        return view('estudiantes.reg_estudiantes');
    }


    /**
     * Nos permite la importación de los datos de un archivo
     */
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

                    if( $numColumnasConDatos >= 1 && $numColumnasVacias >= 1 ){
                        return back()->withErrors([
                            'error' => "En la fila " . $numFilaActual . " hay columnas vacías, revise que todos los datos esten completos e intente nuevamente."
                        ]);
                    }

                    if( rtrim(ltrim($columnasFilaActual[6])) != Auth::user()->clave ){
                        return back()->withErrors([
                            'error' => "En la fila " . $numFilaActual . " la clave de la escuela en el archivo no es la misma a la de usted."
                        ]);
                    }              

                    if( existe_estudiante($columnasFilaActual) ){
                        return back()->withErrors([
                            'error' => "En la fila " . $numFilaActual . " esa matícula ya le pertenece a un estudiante."
                        ]);
                    }
    
                    if($numColumnasConDatos==7 && $numColumnasVacias==0){
                        array_push($filasLimpias,$columnasFilaActual);
                    }

                }                
            }

            $numFilaActual += 1;
        }


        $mensaje = (new Estudiantes())->guardarEstudiantes($filasLimpias);
        return back()->withErrors([
            'error' => $mensaje
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Estudiantes  $estudiantes
     * @return \Illuminate\Http\Response
     */
    public function show($id_estudiante)
    {
        $estudiante = DB::table('estudiantes')->where('id', $id_estudiante)->get()->first();
        if($estudiante->clave == Auth::user()->clave){
            $datos['reportes'] = DB::table('reportes')->where('id_estudiante', $id_estudiante)->orderBy('fecha', 'desc')
            ->join('docentes', 'reportes.id_docente', '=', 'docentes.id')
            ->get();
            $datos['cantidad']= count($datos['reportes']);
            $datos['url_enviada']= url('estudiantes');
            $datos['Alumno'] = $estudiante->Nombre." ".$estudiante->Apaterno." ".$estudiante->Amaterno;
            return view('estudiantes.reportes', $datos);
        }else{
            return "Error";
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Estudiantes  $estudiantes
     * @return \Illuminate\Http\Response
     */
    public function edit(Estudiantes $estudiantes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Estudiantes  $estudiantes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Estudiantes $estudiantes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Estudiantes  $estudiantes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Estudiantes $estudiantes)
    {
        //
    }
}
