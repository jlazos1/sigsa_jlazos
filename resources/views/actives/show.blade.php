@extends('layouts.inventario')

@section('template_title')
    {{ $product->name ?? 'Ver Activo' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Ver Activo</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('actives.index') }}"> Volver </a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <strong>Item:</strong>
                            {{ $active->item }}
                        </div>

                        <div class="form-group">
                            <strong>SKU:</strong>
                            {{ $active->sku }}
                        </div>

                        <div class="form-group">
                            <strong>Marca:</strong>
                            {{ $active->brand }}
                        </div>

                        <div class="form-group">
                            <strong>Modelo:</strong>
                            {{ $active->model }}
                        </div>

                        <div class="form-group">
                            <strong>Número de serie:</strong>
                            {{ $active->serial_number }}
                        </div>

                        <div class="form-group">
                            <strong>Departamento</strong>
                            {{ $active->department }}
                        </div>

                        <div class="form-group">
                            <strong>Lugar de Almacenado:</strong>
                            {{ $nombre_lugar }}
                        </div>

                        <div class="form-group">
                            <strong>Observaciones:</strong>
                            {{ $active->observation }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
