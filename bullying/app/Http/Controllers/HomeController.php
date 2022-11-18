<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $datos['docentes_cantidad'] = DB::table('docentes')
        ->where('clave', Auth::user()->clave)
        ->count();
        $datos['alumnos_cantidad'] = DB::table('estudiantes')
        ->where('clave', Auth::user()->clave)
        ->count();
        $datos['reportes_cantidad'] = DB::table('reportes')
        ->join('docentes', 'reportes.id_docente', '=', 'docentes.id')
        ->where('docentes.clave', Auth::user()->clave)
        ->count();
        $datos['citatorio_cantidad'] = DB::table('citatorios')
        ->join('docentes', 'citatorios.id_docente', '=', 'docentes.id')
        ->where('docentes.clave', Auth::user()->clave)
        ->count();

        return view('home', $datos);
    }
}
