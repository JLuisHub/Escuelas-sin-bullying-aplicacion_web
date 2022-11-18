@extends('layouts.app')

@section('title') {{$titulo}} @endsection

@section('Head')
{{ __($titulo) }}
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
                    {{ __("Listado de ".$tipo) }}
                </div>
                <div class="card-body card-header">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
	                            <th> 
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                       <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                       <circle cx="12" cy="7" r="4"></circle>
                                       <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                    </svg>
                                Docente que lo realizó
                                </th>
                                <th>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                       <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                       <circle cx="9" cy="7" r="4"></circle>
                                       <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                       <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                       <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                    </svg>
                                    Alumno
                                </th>
	                            <th>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-notes" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                       <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                       <rect x="5" y="3" width="14" height="18" rx="2"></rect>
                                       <line x1="9" y1="7" x2="15" y2="7"></line>
                                       <line x1="9" y1="11" x2="15" y2="11"></line>
                                       <line x1="9" y1="15" x2="13" y2="15"></line>
                                    </svg>
                                    Descripción
                                </th>
	                            <th>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-minus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                       <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                       <rect x="4" y="5" width="16" height="16" rx="2"></rect>
                                       <line x1="16" y1="3" x2="16" y2="7"></line>
                                       <line x1="8" y1="3" x2="8" y2="7"></line>
                                       <line x1="4" y1="11" x2="20" y2="11"></line>
                                       <line x1="10" y1="16" x2="14" y2="16"></line>
                                    </svg>
                                    Fecha
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        	@if ($cantidad > 0)
                        		@foreach($contenido as $cont)
		                            <tr>
                                        @foreach($cont as $c)
		                                  <td > {{$c}} </td >
                                        @endforeach
		                            </tr>
		                        @endforeach
                    		@else
                    			<td>
                    				No han realizado {{$tipo}}.
                    			</td>
                    			<td></td><td></td>
                    		@endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection