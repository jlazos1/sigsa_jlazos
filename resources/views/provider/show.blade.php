@extends('layouts.inventario')

@section('title')
    {{ $provider->name ?? 'Mostrar Proveedor' }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-3">
                <a class="btn btn-primary btn-sm mb-3" href="{{ route('providers.index') }}"> VOLVER ATRÁS</a>
                <h2>
                    Proveedor : {{ $provider->name }}
                </h2>

                <div class="form-group">
                    <strong>Rut:</strong>
                    {{ $provider->rut }}
                </div>
                <div class="form-group">
                    <strong>Name:</strong>
                    {{ $provider->name }}
                </div>
                <div class="form-group">
                    <strong>Address:</strong>
                    {{ $provider->address }}
                </div>
                <div class="form-group">
                    <strong>City:</strong>
                    {{ $provider->city }}
                </div>
                <div class="form-group">
                    <strong>Email:</strong>
                    {{ $provider->email }}
                </div>

            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
