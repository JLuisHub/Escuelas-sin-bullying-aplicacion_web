<?php

namespace App\Http\Controllers\V1;


use App\Models\TutorLegal;
use App\Models\Docentes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;
use PhpParser\Node\Stmt\TryCatch;

class AuthTutorLegalAndDocenteController extends Controller
{

    
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
            return response()->json(['error' => $validator->messages(), 'status' => 400 ]);
        }


        //Intentamos hacer login
        try {

            $docenteEncontrado = Docentes::where([
                'email' => $credentials['email'],
            ])->first();
    
            if($docenteEncontrado != null){ // Se encontró al docente
                
                if( Hash::check($credentials['password'], $docenteEncontrado['password']) ){ // contraseña correcta
                    return response()->json([
                        'role' => 'docente',
                        'status' => 200,
                        'docente' => $docenteEncontrado,
                    ]);
                }else{ // Contraseña oncorrecta
                    return response()->json([
                        'message' => 'Contraseña incorrecta',
                        'status' => 400,
                    ]);
                }
            }else{
                //  Buscamos al tutor legal
                $tutorLegal = TutorLegal::where([
                    'email' => $credentials['email'],
                ])->first();
    
                if( $tutorLegal != null ){ // Tutor legal registrado
                    if( Hash::check($credentials['password'], $tutorLegal['password']) ){ // contraseña correcta
                        return response()->json([
                            'role' => 'tutor_legal',
                            'status' => 200,
                            'tutor' => $tutorLegal,
                        ]);
                    }else{ // Contraseña oncorrecta
                        return response()->json([
                            'message' => 'Contraseña incorrecta',
                            'status' => 400,
                        ]);
                    }
                }else{
                    return response()->json([
                        'message' => 'Este correo aún no ha sido registrado',
                        'status' => 400,
                    ],400);
                }
            }

        } catch (Exeption $e) {
            return response()->json([
                'message' => 'Error',
                'status' => 500,
            ]);
        }
    }
}
