@extends('layouts.app')

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
                           {{ __('Área administrativa') }}
                        </div>
                        <div class="col-12 col-md-auto ms-auto d-print-none">
                          <form action="{{ url('busqueda' )}}" method="get">
                              <div >
                                <input type="text" class="form-control" placeholder="Buscar por matrícula..." aria-label="Search in website" name="matricula">
                              </div>
                            </form>
                        </div>
                    </div>

                                
                </div>
                <div class="card-body card-header">
                    <div class="page-wrapper">
                      <div class="page-body">
                          <div class="row row-cards">
                            <div class="col-sm-6 col-lg-3">
                              <div class="card card-md">
                                <div class="card-body text-center">
                                  <div class="text-uppercase text-muted font-weight-medium">

                                  Número de registros:</div>
                                  <div class="display-5 fw-bold my-3">
                                    {{$docentes_cantidad}}
                                  </div>
                                  <div class="text-center mt-4">
                                    <a href="{{url('docentes')}}" class="btn w-100" style="background-color:#001640; font-size:22px; height: 45px; width: 200px;  color: white;">
                                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                       <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                       <circle cx="12" cy="7" r="4"></circle>
                                       <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                    </svg>
                                    Docentes</a>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                              <div class="card card-md">
                                <div class="card-body text-center">
                                  <div class="text-uppercase text-muted font-weight-medium">Número de registros:</div>
                                  <div class="display-5 fw-bold my-3">{{$alumnos_cantidad}}</div>
                                  <div class="text-center mt-4">
                                    <a href="{{url('estudiantes')}}" class="btn btn-green w-100" style="background-color:#001640; font-size:22px; height: 45px; width: 200px;  color: white;">
                                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                         <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                         <circle cx="9" cy="7" r="4"></circle>
                                         <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                         <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                         <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                      </svg> Estudiantes
                                    </a>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                              <div class="card card-md">
                                <div class="card-body text-center">
                                  <div class="text-uppercase text-muted font-weight-medium">Número de registros:</div>
                                  <div class="display-5 fw-bold my-3">{{$reportes_cantidad}}</div>
                                  <div class="text-center mt-4">
                                    <a href="{{url('reportes')}}" class="btn w-100" style="background-color:#001640; font-size:22px; height: 45px; width: 200px;  color: white;">
                                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                         <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                         <rect x="3" y="4" width="18" height="16" rx="3"></rect>
                                         <circle cx="9" cy="10" r="2"></circle>
                                         <line x1="15" y1="8" x2="17" y2="8"></line>
                                         <line x1="15" y1="12" x2="17" y2="12"></line>
                                         <line x1="7" y1="16" x2="17" y2="16"></line>
                                      </svg>
                                    Reportes</a>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                              <div class="card card-md">
                                <div class="card-body text-center">
                                  <div class="text-uppercase text-muted font-weight-medium">Número de registros:</div>
                                  <div class="display-5 fw-bold my-3">{{$citatorio_cantidad}}</div>
                                  <div class="text-center mt-4">
                                    <a href="{{url('citatorios')}}" class="btn w-100" style="background-color:#001640; font-size:22px; height: 45px; width: 200px;  color: white;">
                                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id-badge-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                         <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                         <path d="M7 12h3v4h-3z"></path>
                                         <path d="M10 6h-6a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h16a1 1 0 0 0 1 -1v-12a1 1 0 0 0 -1 -1h-6"></path>
                                         <rect x="10" y="3" width="4" height="5" rx="1"></rect>
                                         <path d="M14 16h2"></path>
                                         <path d="M14 12h4"></path>
                                      </svg>
                                    Citatorios</a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
              </div>
@endsection
