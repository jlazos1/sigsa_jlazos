@extends('layouts.inventario')

@section('title')
    {{ $place->name ?? 'Ubicaciones' }}
@endsection

@section('content')
    <div class="container-fluid mt-3 mb-3">
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-primary mb-3" href="{{ route('places.index') }}"> Volver </a>
                <h2>
                    Ubicación : {{ $place->name }}
                </h2>
                <div class="form-group">
                    <strong>Código:</strong>
                    {{ $place->code }}
                </div>
                <div class="form-group">
                    <strong>Nombre:</strong>
                    {{ $place->name }}
                </div>
            </div>
        </div>
    </div>
@endsection
