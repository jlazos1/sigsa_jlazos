@extends('layouts.inventario')

@section('title', 'Configuración')

@section('content')

    <div class="container mt-3 mb-3">
        <div class="row">
            <div class="col-sm-12">
                <h3>Configuración</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="card mb-3">
                    <div class="row no-gutters">
                        <div class="col-sm-4 align-middle">
                            <img class="pt-3" src="{{ asset('icons/006-entrega-1.png') }}" width="80%">
                        </div>
                        <div class="col-sm-8">
                            <div class="card-body">
                                <h5 class="card-title">Ubicaciones</h5>
                                <p class="card-text">
                                    Las ubicaciones son bodegas, salas u oficinas donde se encuentra el mobiliario
                                    del establecimiento.
                                </p>
                                <a class="form-control btn btn-success" href="{{ route('places.index') }}">
                                    Configurar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="card mb-3">
                    <div class="row no-gutters">
                        <div class="col-sm-4 align-middle">
                            <img class="pt-3" src="{{ asset('icons/007-entrega-2.png') }}" width="80%">
                        </div>
                        <div class="col-sm-8">
                            <div class="card-body">
                                <h5 class="card-title">Carga Masiva de Productos</h5>
                                <p class="card-text">
                                    La carga masiva permite agregar productos al sistema, desde una
                                    planilla excel.
                                </p>
                                <a class="form-control btn btn-success" href="{{ route('config.carga.productos') }}">
                                    Configurar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
