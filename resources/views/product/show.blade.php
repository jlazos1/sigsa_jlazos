@extends('layouts.inventario')

@section('template_title')
    {{ $product->name ?? 'Ver Producto' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Ver Producto</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('products.index') }}"> Volver </a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <strong>Nombre:</strong>
                            {{ $product->name }}
                        </div>
                        <div class="form-group">
                            <strong>Desripción:</strong>
                            {{ $product->description }}
                        </div>
                        <div class="form-group">
                            <strong>Marca:</strong>
                            {{ $product->brand }}
                        </div>
                        <div class="form-group">
                            <strong>Modelo:</strong>
                            {{ $product->model }}
                        </div>
                        <div class="form-group">
                            <strong>SKU:</strong>
                            {{ $product->sku }}
                        </div>
                        <div class="form-group">
                            <strong>Código de Barra:</strong>
                            {{ $product->code }}
                        </div>

                        <div class="form-group">
                            <strong>Precio de compra:</strong>
                            {{ $product->priceBuy }}
                        </div>
                        <div class="form-group">
                            <strong>Precio de venta:</strong>
                            {{ $product->priceSale }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
