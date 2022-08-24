@extends('layouts.inventario')

@section('title')
    Crear Tipo de Producto
@endsection

@section('content')
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-12 mb-4">
                <h2>Nuevo Tipo de Producto</h2>
                <form method="POST" action="{{ route('product_types.store') }}">
                    @csrf
                    @method("POST")
                    <div class="form-group">
                        <label for="">Nombre</label>
                        <input class="form-control" type="text" name='name' value="{{ old('name') ?? '' }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Descripción</label>
                        <input class="form-control" type="text" name='description'
                            value="{{ old('description') ?? '' }}">
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="box-footer mt20">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
