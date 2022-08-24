@extends('layouts.asistencia')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="text-danger">
                <div class="row">
                    <div class="col">
                        Bienvenido(a), <br>{{Auth::user()->name}}
                    </div>
                    <div class="col" style="text-align: right;">
                        <a class="btn btn-primary mt-3 ml-3" href="{{ route('reporte.profesor') }}">
                            <img src="{{ asset('/img/historial.png') }}" width="50"><br>
                            <small>Registros <br>Cargados</small>
                        </a>
                        <a class="btn btn-success mt-3 mr-3" href="{{ route('registro.manual') }}">
                            <img src="{{ asset('/img/mano.png') }}" width="50"><br>
                            <small>Asistencia <br>Manual</small>
                        </a>
                    </div>
                </div>
            </h1>
            <h2>Carga de archivo(s) de asistencia</h2>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="alert alert-info">
                <b>Importante : </b>Aquí puede cargar hasta 15 archivos de asistencia descargados de Teams.<br>
                El archivo que cargue debe ser el de asistencia original, sin modificaciones. Se recomienda no abrir
                el archivo descargado desde Teams para evitar posibles adulteraciones involuntarias.
            </div>
            <form action="{{ route('registro.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input type="file" name="archivos[]" accept=".csv" class="form-control" multiple required>
                </div>
                <button class="btn btn-success mt-2 mb-2">
                    Cargar archivo
                </button>
            </form>
            @if (session()->has("success"))
            <div class="alert alert-success">{{session("success")}}</div>
            @endif
            @if (session()->has("error"))
            <div class="alert alert-danger">{{session("error")}}</div>
            @endif
        </div>
    </div>
</div>
@endsection
