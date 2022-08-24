@extends('layouts.asistencia')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h1>Reportes de Asistencia</h1>
            <a href="{{ route('reporte.curso') }}" class="btn btn-primary form-control mt-2">
                Reporte por Curso
            </a>
            <a href="{{ route('reporte.estudiante') }}" class="btn btn-success form-control mt-2">
                Reporte por Estudiante
            </a>
        </div>
    </div>
</div>
@endsection
