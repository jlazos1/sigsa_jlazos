@extends('layouts.asistencia')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h1>
                Carga de usuarios de Teams
            </h1>
            <h4>(estudiantes, profesores y administrativos)</h4>
            <p class="alert alert-warning">
                <b class="text-danger">Importante</b><br>
                El archivo CSV que debe cargar en esta página, lo encuentra en
                <a target="_blank" href="https://admin.microsoft.com/#/users">https://admin.microsoft.com/#/users</a>
                seleccionando la opción "Exportar usuarios".
            </p>
            <form action="{{ route('estudiante.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="">Seleccione archivo</label>
                    <input type="file" class="form-control" name="archivo" required>
                </div>
                <button class="btn btn-danger mt-2 mb-2">
                    Subir archivo
                </button>
            </form>
            @if (session()->has("success"))
            <div class="alert alert-success">{{ session("success") }}</div>
            @endif

            @if (session()->has("errors"))
            <div class="alert alert-danger">{{ session("errors") }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
