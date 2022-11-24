@extends('layouts.app')

@section('title') Estudiantes @endsection

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



@section('Head')
{{ __('Estudiantes') }}
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if ( session('errors') )
                <div class="alert alert-warning " role="alert">
                    <strong>  {{ session('errors')->first('error') }} 
                    </strong>
                </div>
            @endif

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Editar datos del estudiante') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('/estudiantes/'.$estudiante->id )}}">
                        @csrf
                        {{ method_field('PATCH')}}

                        <div class="row mb-3">
                            <label for="nombre" class="col-md-4 col-form-label text-md-end">{{ __('Nombre') }}</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control @error('nombre') es invalido @enderror" name="nombre" value="{{ $estudiante->Nombre }}" required autocomplete="nombre" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="aPaterno" class="col-md-4 col-form-label text-md-end">{{ __('Apellido paterno') }}</label>

                            <div class="col-md-6">
                                <input id="aPaterno" type="text" class="form-control" name="aPaterno" required value="{{ $estudiante->Apaterno }}"  autofocus>

                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="aMaterno" class="col-md-4 col-form-label text-md-end">{{ __('Apellido materno') }}</label>

                            <div class="col-md-6">
                                <input id="aMaterno" type="text" class="form-control" name="aMaterno" required value="{{ $estudiante->Amaterno}}" autofocus>

                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="aMaterno" class="col-md-4 col-form-label text-md-end">{{ __('Fecha de nacimiento') }}</label>

                            <div class="col-md-6">
                                <input id="FechaNac" type="text" class="form-control" name="FechaNac" required value="{{ $estudiante->FechaNac}}" autofocus>

                            </div>
                        </div>

                        
                        
                        <center>
                                <div class="form-footer">
                                    <hr>
                                    <a href="{{url('estudiantes')}}" class="btn btn-primary" style="background-color:#001640; border-radius: 30px; font-size:20px; width: 180px">
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection