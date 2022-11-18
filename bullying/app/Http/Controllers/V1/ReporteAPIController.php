<?php

namespace App\Http\Controllers\V1;
use App\Models\Reporte;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;


class ReporteAPIController extends Controller
{
    public function store(Request $request)
    {
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
