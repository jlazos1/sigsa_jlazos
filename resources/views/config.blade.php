@extends('layouts.asistencia')
@section('content')

<div class="container">
    <div class="row">
        <div class="col text-center">
            <h1>Configuración</h1>
            <a href="{{ route('estudiante.create') }}" class="btn btn-warning btn-lg mt-3">
                Carga de usuarios de Teams
            </a>
            <a href="{{ route('nomina.carga') }}" class="btn btn-success btn-lg mt-3">
                Carga de Nómina de Estudiantes
            </a>
            <a href="{{ route('nomina.comparacion') }}" class="btn btn-primary btn-lg mt-3">
                Agregar estudiantes a Nómina
            </a>
        </div>
    </div>
</div>

@endsection
