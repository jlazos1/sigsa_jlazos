@extends('layouts.asistencia')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h1>Carga de nómina</h1>
            <form method="POST" action="" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input class="form-control" type="file" name="excel" required>
                </div>
                <div class="form-group mt-3 mb-3">
                    <button class="btn btn-primary">
                        Cargar archivo
                    </button>
                </div>
                @if ($success ?? "")
                <div class="alert alert-success">
                    Se han cargado {{$success}} estudiantes correctamente
                </div>
                @endif
                @if ($error ?? "")
                <div class="alert alert-danger">
                    {{$error}}
                </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
