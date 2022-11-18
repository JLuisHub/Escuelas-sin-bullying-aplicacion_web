@extends('layouts.app')

@section('title') Docentes @endsection

@section('Head')
{{ __('Docentes') }}
@endsection

@section('enlaces')
<a href="{{url('home')}}" class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3" style="color:white; font-size: 20px;">
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
                <div class="card-header">
                    {{ __('Cargar base de datos por archivo CSV') }}
                </div>
                <div class="card-body card-header">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="form-group mb-3 row" >
                            <label class="form-label" style="color:#001640; font-size:20px">1.- Crea un archivo cvs con la siguiente estructura:</label>
                        </div>
                    </div>
                    <div class="page-body">
                        <div class="container-xl">
                            <div class="row row-cards">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="table-responsive">
                                            <table class="table table-vcenter card-table">
                                            <thead>
                                                <tr>
                                                <th>Matrícula</th>
                                                <th>Nombre</th>
                                                <th>Apellido paterno</th>
                                                <th>Apellido materno</th>
                                                <th>Contraseña</th>
                                                <th>Correo electrónico</th>
                                                <th>Clave de la escuela</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                <td >39201458</td>
                                                <td>Jose  </td>
                                                <td > Salazar</td>
                                                <td> Jimenez</td>
                                                <td>Temporal </td>
                                                <td>ejemplo@gmail.com </td>
                                                <td>123456 </td>
                                                </tr>

                                                <tr>
                                                <td >39201499</td>
                                                <td>Juan  </td>
                                                <td > Dominguez</td>
                                                <td> Yahoiu</td>
                                                <td>Temporal </td>
                                                <td>ejemplo2@gmail.com </td>
                                                <td>123456 </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form  action="{{ url('/docentes' )}}" method="POST" enctype="multipart/form-data" >
                        {{ csrf_field() }}          
                        <div class="card-body">
                            <div class="form-group mb-3 row" >
                                <label class="form-label" style="color:#001640; font-size:20px">2.- Seleccione el archivo:</label>
                                
                                <input class="form-control form-control-rounded mb-2" type="file" name="file" style="width: 350px">
                                
                            </div>
                                
                                <center>
                                <div class="form-footer">
                                    <hr>
                                    <a href="{{url('docentes')}}" class="btn btn-primary" style="background-color:#001640; border-radius: 30px; font-size:20px; width: 180px">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                           <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                           <line x1="5" y1="12" x2="19" y2="12"></line>
                                           <line x1="5" y1="12" x2="9" y2="16"></line>
                                           <line x1="5" y1="12" x2="9" y2="8"></line>
                                        </svg> Regresar
                                    </a>
                                    <button type="submit" class="btn btn-primary" style="background-color:#001640; border-radius: 30px; font-size:20px; width: 180px">
                                        Guardar cambios
                                    </button>
                                </div>
                                </center>
                                
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection