<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Estudiantes;

class EstudianteAPIController extends Controller
{

    public function showAll($clave)
    {
        $datos = Estudiantes::all() -> where('clave',$clave);
        return response() -> json($datos);
    }
}
