@extends('layouts.app')

@section('title') Estudiantes @endsection

@section('Head')
{{ __('Estudiantes') }}
@endsection

@section('enlaces')
<a href="{{route('home')}}" class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3" style="color:white; font-size: 20px;">
    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-layout-dashboard" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
        <path d="M4 4h6v8h-6z"></path>
        <path d="M4 16h6v4h-6z"></path>
        <path d="M14 12h6v8h-6z"></path>
        <path d="M14 4h6v4h-6z"></path>
    </svg>Volver al tablero          
</a>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div >
            <div class="card" style="min-width: 280px ">
                <div class="card-header">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-vocabulary" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                       <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                       <path d="M10 19h-6a1 1 0 0 1 -1 -1v-14a1 1 0 0 1 1 -1h6a2 2 0 0 1 2 2a2 2 0 0 1 2 -2h6a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-6a2 2 0 0 0 -2 2a2 2 0 0 0 -2 -2z"></path>
                       <path d="M12 5v16"></path>
                       <path d="M7 7h1"></path>
                       <path d="M7 11h1"></path>
                       <path d="M16 7h1"></path>
                       <path d="M16 11h1"></path>
                       <path d="M16 15h1"></path>
                    </svg>
                    {{ __("Listado de reportes del alumna/o: ".$Alumno) }}
                </div>
                <div class="card-header">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ad-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                       <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                       <path d="M11.933 5h-6.933v16h13v-8"></path>
                       <path d="M14 17h-5"></path>
                       <path d="M9 13h5v-4h-5z"></path>
                       <path d="M15 5v-2"></path>
                       <path d="M18 6l2 -2"></path>
                       <path d="M19 9h2"></path>
                    </svg>
                    Número de reportes recibidos: {{$cantidad}}
                </div>
                <div class="card-body card-header">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
	                            <th>Docente que lo realizó</th>
	                            <th>Descripción</th>
	                            <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@if ($cantidad > 0)
                        		@foreach($reportes as $reporte)
		                            <tr>
		                                <td > {{$reporte-> Nombre." ".$reporte-> Apaterno." ".$reporte-> Amaterno}} </td >
		                                <td >{{$reporte -> descripcion }} </td >
		                                <td >{{$reporte -> fecha }} </td >
		                            </tr>
		                        @endforeach
                    		@else
                    			<td>
                    				No se le han realizado reportes al estudiante.
                    			</td>
                    			<td></td><td></td>
                    		@endif
                        </tbody>
                    </table>
                </div>
                <a href={{$url_enviada}} style="background-color:#001640; border-radius: 5px; font-size:15px"  type="submit" class="btn btn-primary w-100">
                	<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
					   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
					   <line x1="5" y1="12" x2="19" y2="12"></line>
					   <line x1="5" y1="12" x2="9" y2="16"></line>
					   <line x1="5" y1="12" x2="9" y2="8"></line>
					</svg> Regresar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
