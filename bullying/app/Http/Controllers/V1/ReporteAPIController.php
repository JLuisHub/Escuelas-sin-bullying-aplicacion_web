<?php

namespace App\Http\Controllers\V1;
use App\Models\Reporte;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Validator;



class ReporteAPIController extends Controller
{
    public function store(Request $request)
    {
        //  Filtramos la solicitud y solo tomamos los datos que nos interesan.
        $datos_de_peticion = $request->only('id_docente','id_estudiante','descripcion','fecha');

        //  Realizamos validaciones sobre los datos de la petición
        $validator = Validator::make($datos_de_peticion, [
            'id_docente' => 'required|numeric',
            'id_estudiante' => 'required|numeric',
            'descripcion'  => 'required',
            'fecha' => 'required',
        ]);

        //  Devolvemos un error si fallan las validaciones
        if($validator->fails()){
            return response()->json(['message' => "Algún campo esta incompleto o no tiene el valor apropiado"], 400);
        }

        //  Valido que el estudiante citado y el profesor esten registrados dentro de la misma escuela
        //  Busco en la base de datos si existe el Id de docente
        $profesor_encontrado = DB::table('docentes')->where('id', $request->id_docente)->get();

        if( empty($profesor_encontrado[0]) ){ // Profesor no encontrado
            return response()->json( ['message' => 'id de profesor invalido.' ], 400);
        }

        //  Busco en la base de datos si existe el Id del estudiante
        $estudiante_encontrado = DB::table('estudiantes')->where('id', $request->id_estudiante)->get();
        if( empty($estudiante_encontrado[0]) ){ // Estudiante no encontrado.
            return response()->json( ['message' => 'id de estudiante invalido.' ], 400);
        }

        //  Valido que tanto el profesor como el estudiante citado esten registrados en la misma escuela.
        if( $profesor_encontrado[0]->clave != $estudiante_encontrado[0]->clave ){
            return response()->json( ['message' => 'El alumno y el profesor no pertenecen a la misma escuela' ], 400);
        }

        //  Valida que estudiante tenga algun tutor vinculado.
        $tutores_legales_encontrados = DB::table('estudiantes_tutores_legales')->where('id_estudiante', $request->id_estudiante)->get();
        if(  empty($tutores_legales_encontrados[0]) ){ // alumno sin tutores legales asociados
            return response()->json( ['message' => 'El estudiante seleccionado no tiene ningún tutor legal asignado.' ], 400);
        }

        $reporte_temp = new Reporte();
        $reporte_temp->id_docente = $request->id_docente;
        $reporte_temp->id_estudiante = $request->id_estudiante;
        $reporte_temp->descripcion = $request->descripcion;
        $reporte_temp->fecha = $request->fecha;
        // Intentamos guardar el nuevo registro en la base de datos.
        try{
            $reporte_temp->save();
            return response()->json([
                'message' => 'Se ha creado el reporte exitosamente',
            ],Response::HTTP_OK);
        } catch(exception $e) {
                return response()->json([
                    'message' => 'Ocurrio un error al guardar el reporte',
                ], 400);
        }
    }

    public function destroy(Request $request,Reporte $reporte)
    {
        // Se obtiene obtine una respuesta al intentar eliminar un reporte
        $reporte = Reporte::destroy($id_reporte=($request->id_reporte));
        
        // Se compara el resultado obtenido
        if($reporte == 0){
            return response() -> json("Hubo un error al eliminar el reporte, intente más tarde");
        }else{
            return response() -> json("Eliminado con éxito");
        }
    }

    public function showEstudiante($id) {
        $datos = Reporte::where('id_estudiante',$id) ->get();
        return response() -> json($datos);
    }

}
