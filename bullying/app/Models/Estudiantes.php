<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;


class Estudiantes extends Model
{
    #use HasFactory;
    //Nos permite el almacenamiento de los datos uno por uno que se encuentrar en un archivo cvs
    public $timestamps = false;
    protected $fillable = ['Matricula', 'Nombre','Apaterno','Amaterno','Contrasenia','FechaNac','clave']; 
    
    public function guardarEstudiantes($estudiantes){
        foreach($estudiantes as $dato_docente){
            $estudiante = new Estudiantes();
            $estudiante->Matricula = rtrim(ltrim($dato_docente[0]));
            $estudiante->Nombre = rtrim(ltrim($dato_docente[1]));
            $estudiante->Apaterno = rtrim(ltrim($dato_docente[2]));
            $estudiante->Amaterno = rtrim(ltrim($dato_docente[3]));
            $estudiante->Contrasenia = Hash::make(rtrim(ltrim($dato_docente[4])));
            $estudiante->FechaNac = rtrim(ltrim($dato_docente[5]));
            $estudiante->clave = rtrim(ltrim($dato_docente[6]));
            $estudiante->save();
        }
        return "Se han guardado exitosamente los registros.";
    }


}
