@extends('layouts.inventario')

@section('title')
    Actualizar Bodega/Lugar
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-3 mb-3">
                <h2>Actualizar Bodega/Lugar</h2>
                <form method="POST" action="{{ route('places.update', $place->id) }}">
                    @csrf
                    @method("PUT")

                    <div class="form-group">
                        <label>Código</label>
                        <input class="form-control" type="text" name="code" value="{{ $place->code }}" required />
                        @error('code')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Nombre</label>
                        <input class="form-control" type="text" name="name" value="{{ $place->name }}" required />
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary">Actualizar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
