@extends('layouts.inventario')

@section('title')
    Actualizar Producto
@endsection

@section('content')
    <div class="container-fluid mb-3">
        <div class="row">
            <div class="col-md-12">
                <h2>Actualizar Producto</h2>
                <form method="POST" action="{{ route('products.update', $product->id) }}">
                    @csrf
                    @method("PUT")
                    <div class="form-group">
                        <label>Nombre</label>
                        <input class="form-control" type="text" name='name' value="{{ $product->name }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Descripción</label>
                        <input class="form-control" type="text" name='description' value="{{ $product->description }}">
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
                        <input class="form-control" type="text" name='brand' value="{{ $product->brand }}">
                        @error('brand')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Modelo</label>
                        <input class="form-control" type="text" name='model' value="{{ $product->model }}">
                        @error('model')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>SKU</label>
                        <input class="form-control" type="text" name='sku' value="{{ $product->sku }}">
                        @error('sku')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Código de Barra</label>
                        <input class="form-control" type="number" name='code' value="{{ $product->code }}">
                        @error('code')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Precio de Compra</label>
                        <input class="form-control" type="number" name='priceBuy' value="{{ $product->priceBuy }}">
                        @error('priceBuy')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Precio de Venta</label>
                        <input class="form-control" type="number" name='priceSale' value="{{ $product->priceSale }}">
                        @error('priceSale')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="box-footer mt20">
                        <button type="submit" class="btn btn-primary">Actualizar producto</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
