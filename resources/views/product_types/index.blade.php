@extends('layouts.inventario')

@section('title')
    Tipos de Producto
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <h2>
                    Tipos de Producto
                    <a href="{{ route('product_types.create') }}" class="btn btn-primary mb-2 float-right">
                        Nuevo
                    </a>
                </h2>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success mb-2">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                @if ($message = Session::get('error'))
                    <div class="alert alert-danger mb-2">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                <table id="table_id" class="table table-striped table-hover">
                    <thead class="thead">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product_types as $proTy)
                            <tr>

                                <td>{{ $proTy->id }}</td>
                                <td>{{ $proTy->name }}</td>
                                <td>{{ $proTy->description }}</td>
                                <td>
                                    <form action="{{ route('product_types.destroy', $proTy->id) }}" method="POST">
                                        <a class="btn btn-sm btn-primary "
                                            href="{{ route('product_types.show', $proTy->id) }}">
                                            <i class="material-icons">visibility</i>
                                        </a>
                                        <a class="btn btn-sm btn-success"
                                            href="{{ route('product_types.edit', $proTy->id) }}">
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
