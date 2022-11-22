<?php

namespace App\Http\Controllers\V1;

use JWTAuth;
use App\Models\TutorLegal;
use App\Models\Docentes;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


class AuthTutorLegalController extends Controller
{

    public function index()
    {
        return view('TutorLegal.registra');
    }

    public function create()
    {
        // Hace llamar al template para registrar tutores legales
        return view('TutorLegal.registra');
    }


    //  Función que utilizaremos para registrar al usuario
    public function store(Request $request)
    {
        //  Indicamos que solo queremos recibir email y password de la request
        $data = $request->only('email', 'nombre','aPaterno','aMaterno','password','passwordConfirm');

        //  Realizamos las validaciones
        //  Se valida que el email no haya sido introducido anteriormente por un docente o directivo.
        
        $validator = Validator::make($data, [
            'password' => 'required|string|min:6|max:50',
            'passwordConfirm' => 'required|string|min:6|max:50',
        ]);

        if(strlen($request->password)<6 and strlen($request->passwordConfirm)<6){
            return back()->withErrors([
                'error'=>
                'Las contraseñas deben de tener una longitud mínima de 6 caracteres.'
            ]);
        }


        if( $request->password != $request->passwordConfirm ){
            return back()->withErrors([
                'error'=>
                $request->password.' '.$request->passwordConfirm 
            ]);
        }

        try{
            //  Registramos al tutor legal en la base de datos.
            $user = TutorLegal::create([
                'email' => $request->email,
                'nombre' => $request->nombre,
                'aPaterno' => $request->aPaterno,
                'aMaterno' => $request->aMaterno,
                'password' => bcrypt($request->password)
            ]);

        } catch (Exeption $e){
            return back()->withErrors([
                'error'=>
                'Ha ocurrido un error al momento de registrar la cuenta.'
            ]);
        }
        
        //Nos guardamos el usuario y la contraseña para realizar la petición de token a JWTAuth
        $credentials = $request->only('email', 'password');

        //Devolvemos la respuesta con el token del usuario
        return back()->withErrors([
                'error'=>
                'La cuenta se ha registrado exitosamente.'
            ]);
    }

    public function authenticate(Request $request)
    {
        //Indicamos que solo queremos recibir email y password de la request
        $credentials = $request->only('email', 'password');

        //Validaciones
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);
        

        //  Devolvemos un error de validación en caso de fallo en las verificaciones
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Intentamos hacer login
        try {

            $user = TutorLegal::where([
                'email' => $credentials['email'],
            ])->first();

            if ( $user == null || !Hash::check($credentials['password'], $user['password']) ) {
                //Credenciales incorrectas.
                return response()->json([
                    'message' => 'Login failed',
                ], 401);
            }
            
        } catch (JWTException $e) {
            return response()->json([
                'message' => 'Error',
            ], 500);
        }
        //Devolvemos el token
        $token = JWTAuth::fromUser($user);
        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }


    public function logout(Request $request)
    {
        //Validamos que se nos envie el token
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);
        
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        try {
            //Si el token es valido eliminamos el token desconectando al usuario.
            JWTAuth::invalidate($request->token);
            return response()->json([
                'success' => true,
                'message' => 'User disconnected'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Error'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
