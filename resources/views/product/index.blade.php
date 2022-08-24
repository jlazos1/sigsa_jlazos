@extends('layouts.inventario')

@section('title')
    Productos
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <h2>
                    Productos
                    <a href="{{ route('products.create') }}" class="btn btn-primary mb-2 float-right">
                        Nuevo Producto
                    </a>
                </h2>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success mb-2">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                <table id="table_id" class="table table-striped table-hover">
                    <thead class="thead">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Modelo</th>
                            <th>Sku</th>
                            <th>Codigo</th>
                            <th>Marca</th>
                            <th>P. Compra</th>
                            <th>P. Venta</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->model }}</td>
                                <td>{{ $product->sku }}</td>
                                <td>{{ $product->code }}</td>
                                <td>{{ $product->brand }}</td>
                                <td>{{ $product->priceBuy }}</td>
                                <td>{{ $product->priceSale }}</td>

                                <td>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                        <a class="btn btn-sm btn-primary "
                                            href="{{ route('products.show', $product->id) }}">
                                            <i class="material-icons">visibility</i>
                                        </a>
                                        <a class="btn btn-sm btn-success"
                                            href="{{ route('products.edit', $product->id) }}">
                                            <i class="material-icons">edit</i>
                                        </a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="material-icons">delete</i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
