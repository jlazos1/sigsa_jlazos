@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row text-center mt-2">
            <div class="col-sm-4 offset-sm-4">
                <img src="{{ asset('img/logo.png') }}" width="150px;">
                <h3>La sesión de usuario se ha cerrado por inactividad</h3>
                <a href="/">Ir a la página principal</a>
            </div>
        </div>
    </div>
@endsection
