<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Docentes;
use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class DocentesAPIController extends Controller
{
    protected $user;
    public function __construct(Request $request)
    {
        $token = $request->header('Authorization');
        if($token != '')
            //En caso de que requiera autentifiación la ruta obtenemos el usuario y lo almacenamos en una variable, nosotros no lo utilizaremos.
            $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function show($clave){
        $docentes = Docentes::where('clave',$clave)->get();
        return $docentes;
    }

    public function cambiarContrasenia(Request $request){
        $id = $request->id;
        $contrasenia = $request->contrasenia;
        $contrasenia_2= $request->contrasenia_2;

        // Verificar que no existan campos varios
        if(empty($id) or empty($contrasenia) or empty($contrasenia_2)){

            // Devolver un mensaje de error
            return response()->json([
                    'message' => 'Hay campos vacios.',
                ], 400);
        }
        try{

            // Verficar que la contraseña se al misma
            if($contrasenia==$contrasenia_2){
                $docente = Docentes::find($id);
                $docente->password =  Hash::make($contrasenia);
                $docente->save();
                return response()->json([
                    'message' => 'Se ha cambiado la contraseña correctamente.',
                ], 400);
            }else{
                // Si no lo es, se envia un mensaje de error
                return response()->json([
                    'message' => 'Las contraseñas no coinciden.',
                ], 400);
            }
        } catch(exception $e) {
            // Si ocurre un error, se manda un mensaje
            return response()->json([
                'message' => 'Ocurrio un error al cambiar la contraseña.',
            ], 400);
        }
    }

}