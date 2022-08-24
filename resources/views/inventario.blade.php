@extends('layouts.inventario')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <h1 class="mt-3 mb-3">¿Qué desea hacer?</h1>
                <div class="row">
                    <div class="col mt-3">
                        <div class="card-group">
                            <div class="card border-primary mb-3">
                                <div class="card-header bg-primary text-white">AGREGAR DOCUMENTO DE ENTRADA</div>
                                <div class="card-body text-primary">
                                    <h5 class="card-title">Entrada de mobiliario</h5>
                                    <p class="card-text">
                                        En esta sección puede registrar Facturas u otros documentos que evidencien la
                                        entrada de muebles al establecimiento.
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <a class="btn btn-primary" href="{{ route('entrada.registrar') }}">Continuar</a>
                                </div>
                            </div>
                            <div class="card border-danger mb-3">
                                <div class="card-header bg-danger text-white">AGREGAR DOCUMENTO DE SALIDA</div>
                                <div class="card-body text-danger">
                                    <h5 class="card-title">Salida de mobiliario</h5>
                                    <p class="card-text">
                                        En esta sección puede registrar Guías de Despacho u otros documentos que evidencien
                                        la salida de muebles dentro y fuera del establecimiento.
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <a class="btn btn-danger" href="{{ route('salida.registrar') }}">Continuar</a>
                                </div>
                            </div>
                            <div class="card border-warning mb-3">
                                <div class="card-header bg-warning text-white">VER LISTA DE MOVIMIENTOS</div>
                                <div class="card-body text-warning">
                                    <h5 class="card-title">Lista de movimientos</h5>
                                    <p class="card-text">
                                        En esta sección puede agregar facturas de compra u otros documentos que evidencien
                                        la entrada de productos externos al establecimiento.
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <a class="btn btn-warning" href="{{ route('documents.index') }}">Continuar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
