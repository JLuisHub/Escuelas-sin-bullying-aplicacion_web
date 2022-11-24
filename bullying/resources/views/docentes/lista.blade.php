@extends('layouts.app')

@section('title') Docentes @endsection

@section('Head')
{{ __('Docentes') }}
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
            @if ( session('errors') )
                <div class="alert alert-warning " role="alert">
                    <strong>  {{ session('errors')->first('error') }} 
                    </strong>
                </div>
            @endif

            <div class="card" style="min-width: 280px ">
                <div class="card-header ">
                    <div class="row g-2 align-items-center" >
                        <div class="col">
                           {{ __('Listado de docentes') }}
                        </div>
                        <div class="col-12 col-md-auto ms-auto d-print-none">
                          <div>
                            <a href="{{url('docentes/create')}}" class="btn btn-primary"  style="background-color:#001640; font-size:15px; height: 35px; width: 200px;  ">
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" >
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                              </svg>
                              CSV
                            </a>
                          </div>
                        </div>
                    </div>
                                
                </div>
                <div class="card-body card-header">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                            <th>Matrícula</th>
                            <th>Nombre</th>
                            <th>Opciones</th>
                            <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($docentes as $docente)
                            <tr>
                                <td >
                                     <a href="{{url('docentes/reportes',$docente -> id )}}" style="background-color:#001640; border-radius: 5px; font-size:12px"  type="submit" class="btn btn-primary w-100"> {{$docente -> Matricula }}</a>
                                </td >
                                <td >{{$docente -> Nombre }} {{$docente -> Apaterno }} {{$docente -> Amaterno }}</td >
                                <td>
                                    <form method="GET" action="{{ url('docentes/eliminar', $docente -> id ) }}">
                                        <button type="submit" style="background-color:#001640; border-radius: 5px; font-size:12px; color: white;">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                               <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                               <path d="M4 7h16"></path>
                                               <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                               <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                               <path d="M10 12l4 4m0 -4l-4 4"></path>
                                            </svg>
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{url('docentes/'.$docente -> id.'/edit')}}" type="submit" style="background-color:#001640; border-radius: 5px; font-size:12px; color: white;" class="btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-pencil" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                           <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                           <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                           <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                           <path d="M10 18l5 -5a1.414 1.414 0 0 0 -2 -2l-5 5v2h2z"></path>
                                        </svg>
                                        Editar
                                    </a>   
                                </td>
                                
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <hr>
                    <div style="text-align:center">
                        <a href="{{ $docentes->previousPageUrl()}}" class="btn btn-primary" style="background-color:#001640">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                               <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                               <line x1="5" y1="12" x2="19" y2="12"></line>
                               <line x1="5" y1="12" x2="9" y2="16"></line>
                               <line x1="5" y1="12" x2="9" y2="8"></line>
                            </svg> Anterior  
                        </a> 

                        <a href="{{ $docentes->nextPageUrl()}}" class="btn btn-primary" style="background-color:#001640">
                            Siguiente
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-right" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                               <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                               <line x1="5" y1="12" x2="19" y2="12"></line>
                               <line x1="15" y1="16" x2="19" y2="12"></line>
                               <line x1="15" y1="8" x2="19" y2="12"></line>
                            </svg> 
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
