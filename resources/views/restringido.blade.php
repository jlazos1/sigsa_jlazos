@extends('layouts.simple')
@section('content')
<div class="container">
    <div class="row">
        <div class="col text-center">
            <img class="mt-3" src="{{ asset('img/homero.gif') }}" alt="">
            <h1 class="mt-3">
                {{ $mensaje ?? "" }}
            </h1>
            <a class="btn btn-danger btn-lg" href="/">Volver a la página principal</a>
        </div>
    </div>
</div>
@endsection
