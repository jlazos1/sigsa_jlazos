@extends('layouts.inventario')

@section('title')
    Editar Tipo de Producto
@endsection

@section('content')
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-12 mb-4">
                <h2>Editar Tipo de Producto</h2>
                <form method="POST" action="{{ route('product_types.update', $product_type->id) }}">
                    @csrf
                    @method("PUT")
                    <div class="form-group">
                        <label for="">Nombre</label>
                        <input class="form-control" type="text" name='name'
                            value="{{ $product_type->name }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Descripción</label>
                        <input class="form-control" type="text" name='description'
                            value="{{ $product_type->description }}">
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
