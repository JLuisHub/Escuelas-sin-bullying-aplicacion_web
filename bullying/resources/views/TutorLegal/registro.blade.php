@extends('layouts.app')

@section('Head')
{{ __('Registra tu cuenta') }}
@endsection


<style>
    .noti_err {
      padding: 20px;
      background-color: #f44336;
      color: white;
    }

    .noti_exi {
      padding: 20px;
      background-color: #2fe666;
      color: white;
    }
    
    .closebtn {
      margin-left: 15px;
      color: white;
      font-weight: bold;
      float: right;
      font-size: 22px;
      line-height: 20px;
      cursor: pointer;
      transition: 0.3s;
    }
    
    .closebtn:hover {
      color: black;
    }
    </style>

@section('content')
<div class="container">

    

    <div class="row justify-content-center">
        

        <div class="col-md-8">

            <div class="noti_err mb-4" id="notificacion_error" style="display: none" >
                <span class="closebtn" onclick="this.parentElement.style.display='none';" >&times;</span> 
                <strong  id="notificacion_error_texto" class="mensaje_error">Indicates a dangerous or potentially negative action.</strong> 
            </div>

            <div class="noti_exi mb-4" id="notificacion_exito" style="display: none" >
                <span class="closebtn" onclick="this.parentElement.style.display='none';" >&times;</span> 
                <strong  id="notificacion_exito_texto" class="mensaje_error">Indicates a dangerous or potentially negative action.</strong> 
            </div>

            <div class="card">

                <div class="card-body">

                        <div class="row mb-3">
                            <label for="nombre" class="col-md-4 col-form-label text-md-end">{{ __('Nombre: ') }}</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control" name="nombre" required value="{{ old('nombre') }}"  autofocus>

                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="aPaterno" class="col-md-4 col-form-label text-md-end">{{ __('Apellido paterno') }}</label>

                            <div class="col-md-6">
                                <input id="aPaterno" type="text" class="form-control" name="aPaterno" required value="{{ old('aPaterno') }}"  autofocus>

                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="aMaterno" class="col-md-4 col-form-label text-md-end">{{ __('Apellido materno') }}</label>

                            <div class="col-md-6">
                                <input id="aMaterno" type="text" class="form-control" name="aMaterno" required value="{{ old('aMaterno') }}"  autofocus>

                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Correo electrónico') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="passwordConfirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirmar contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="passwordConfirm" type="password" class="form-control" name="passwordConfirm" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" onclick="enviarDatos()" >
                                    {{ __('Registrar mi cuenta como tutor legal') }}
                                </button>
                            </div>
                        </div>
            </div>
        </div>
    </div>
</div>

<script>

    // Example POST method implementation:
    async function postData(url = '', data = {}) {
      // Default options are marked with *
      const response = await fetch(url, {
        method: 'POST', // *GET, POST, PUT, DELETE, etc.
        mode: 'cors', // no-cors, *cors, same-origin
        cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
        headers: {
          'Content-Type': 'application/json'
          // 'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: JSON.stringify(data) // body data type must match "Content-Type" header
      });
      return response.json(); // parses JSON response into native JavaScript objects
    }
    
    function enviarDatos(){

        data = {
            email : document.getElementById('email').value,
            nombre : document.getElementById('nombre').value,
            aPaterno : document.getElementById('aPaterno').value,
            aMaterno : document.getElementById('aMaterno').value,
            password : document.getElementById('password').value,
            passwordConfirm : document.getElementById('passwordConfirm').value
        }
    
        postData('http://54.225.152.112/api/v1/tutor_legal/register', data )
        .then(
        function(response) {

            console.log(response.status)

            if (response.status !== 200) {

                texto = "";
                if( response.error.nombre != undefined ){
                    texto = response.error.nombre;
                }else if( response.error.aPaterno != undefined ){
                    texto = response.error.aPaterno;
                }else if( response.error.aMaterno != undefined ){
                    texto = response.error.aMaterno;
                }else if( response.error.email != undefined ){
                    texto = response.error.email;
                }else if( response.error.password != undefined ){
                    texto = response.error.password;
                }else if( response.error.passwordConfirm != undefined ){
                    texto = response.error.passwordConfirm;
                }else{
                    texto = response.error;
                }
                    
                notificacion_error = document.querySelector('#notificacion_error');
                notificacion_error_texto = document.querySelector('#notificacion_error_texto');
                notificacion_error.setAttribute('style','display:inblock');
                notificacion_error_texto.textContent = texto;

                return;
            }else{

                notificacion_error = document.querySelector('#notificacion_exito');
                notificacion_error_texto = document.querySelector('#notificacion_exito_texto');
                notificacion_error.setAttribute('style','display:inblock');
                notificacion_error_texto.textContent = response.message;
            }

        })
        .catch(function(err) {
            console.log('Fetch Error :-S', err);
            notificacion_error = document.querySelector('#notificacion_error');
            notificacion_error_texto = document.querySelector('#notificacion_error_texto');
            notificacion_error.setAttribute('style','display:inblock');
            notificacion_error_texto.textContent = "Ocurrió un error en el sitio. Por favor, intentalo más tarde.";
        });
    }
        
</script>


@endsection
