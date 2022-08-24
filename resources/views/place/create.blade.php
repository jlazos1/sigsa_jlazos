@extends('layouts.inventario')

@section('title')
    Crear Lugar
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2>Crear Lugar</h2>
                <form method="POST" action="{{ route('places.store') }}">
                    @csrf
                    @method("POST")
                    <div class="form-group">
                        <label>Código</label>
                        <input class="form-control" type="text" name="code" value="{{ old('code') ?? '' }}" required />
                        @error('code')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Nombre</label>
                        <input class="form-control" type="text" name="name" value="{{ old('name') ?? '' }}" required />
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary">Agregar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
