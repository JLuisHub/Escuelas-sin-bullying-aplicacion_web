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
        
        $file = file($request->file->getRealPath()); 
        $data = array_slice($file,1); // Nos permite eliminar la primera linea del archivo
        $datos =[];
        $tamanio = count($data);
        if($tamanio!=0){
            for($i=0; $i<$tamanio; $i++){
                $dato = $data[$i];
                $columnas = explode(",",$dato);
                $tam = count($columnas);
                $bol = False;
                $contador = 0;
                for($j=0; $j<$tam; $j++){
                    if(rtrim(ltrim($columnas[$j]))==""){
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
                    if(!existe_estudiante($columnas)){
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
                'error' => "El archivo ingresado no contiene registros"
            ]);
        }

        $mensaje = (new Estudiantes())->guardarEstudiantes($datos);
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
