<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Exception;


class Docentes extends Authenticatable implements JWTSubject
{

    use HasFactory;
    //Nos permite el almacenamiento de los datos uno por uno que se encuentrar en un archivo cvs
    public $timestamps = false;
    protected $fillable = ['Matricula', 'Nombre','Apaterno','Amaterno','password','email','clave']; 

    public function guardarDocentes($docentes){
        foreach($docentes as $dato_docente){
            try{
                $docente = new Docentes();
                $docente->Matricula = rtrim(ltrim($dato_docente[0]));
                $docente->Nombre = rtrim(ltrim($dato_docente[1]));
                $docente->Apaterno = rtrim(ltrim($dato_docente[2]));
                $docente->Amaterno = rtrim(ltrim($dato_docente[3]));
                $docente->password = Hash::make(rtrim(ltrim($dato_docente[4])));
                $docente->email = rtrim(ltrim($dato_docente[5]));
                $docente->clave = rtrim(ltrim($dato_docente[6]));
                $docente->save();
            } catch(Exeption $e){
                return $e;
            }
            
        }
        return "Se han guardado exitosamente los registros";
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [
            'email' => $this->email,
        ];
    }
    
}
