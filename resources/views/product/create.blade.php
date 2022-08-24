@extends('layouts.inventario')

@section('template_title')
    Create Product
@endsection

@section('content')
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-12 mb-4">
                <h2>Nuevo Producto</h2>
                <form method="POST" action="{{ route('products.store') }}">
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
                    <div class="form-group">
                        <label>Tipo de Producto</label>
                        <select name="product_type_id" id="product_type_id" class="form-control">
                            <option value="-1">Seleccione una opción</option>
                            @foreach ($product_types as $proTy)
                                <option value="{{ $proTy->id }}"> {{ $proTy->name }}</option>
                            @endforeach
                        </select>
                        @error('product_type')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Marca</label>
                        <input class="form-control" type="text" name='brand' value="{{ old('brand') ?? '' }}">
                        @error('brand')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Modelo</label>
                        <input class="form-control" type="text" name='model' value="{{ old('model') ?? '' }}">

                        @error('model')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>SKU</label>
                        <input class="form-control" type="text" name='sku' value="{{ old('sku') ?? '' }}">

                        @error('sku')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Código de Barra</label>
                        <input class="form-control" type="number" name='code' value="{{ old('code') ?? '' }}">
                        @error('code')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Precio de Compra</label>
                        <input class="form-control" type="number" name='priceBuy' value="{{ old('priceBuy') ?? '' }}">
                        @error('priceBuy')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Precio de Venta</label>
                        <input class="form-control" type="number" name='priceSale'
                            value="{{ old('priceSale') ?? '' }}">
                        @error('priceSale')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="box-footer mt20">
                        <button type="submit" class="btn btn-primary">Crear producto</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
