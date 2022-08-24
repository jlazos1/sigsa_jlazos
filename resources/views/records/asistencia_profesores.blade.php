@extends('layouts.asistencia')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h1>Registro profesores</h1>
            <p class="mt-3 mb-3">
                Informe de Registro de Asistencia. En este informe podrá visualizar si se
                ha cargado la asistencia correctamente. Los registros en X significa que no se ha
                cargado asistencia para la fecha y bloque horario seleccionado.
            </p>
            @livewire('teacher-component')
        </div>
    </div>
</div>
@endsection
