<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Docentes;
use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Hash;
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
        if(empty($id) or empty($contrasenia) or empty($contrasenia_2)){
            return response()->json([
                    'message' => 'Hay campos vacios.',
                ], 400);
        }
        try{
            if($contrasenia==$contrasenia_2){
                $docente = Docentes::find($id);
                $docente->password =  Hash::make($contrasenia);
                $docente->save();
                return response()->json([
                    'message' => 'Se ha cambiado la contraseña correctamente.',
                ], 400);
            }else{
                return response()->json([
                    'message' => 'Las contraseñas no coinciden.',
                ], 400);
            }
        } catch(exception $e) {
            return response()->json([
                'message' => 'Ocurrio un error al cambiar la contraseña.',
            ], 400);
        }
    }
}
