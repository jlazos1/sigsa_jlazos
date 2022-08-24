@extends('layouts.inventario')

@section('title')
    Proveedores
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 mb-3 mt-3">
                <h2>
                    Proveedores
                    <a href="{{ route('providers.create') }}" class="btn btn-primary btn-sm float-right"
                        data-placement="left">
                        NUEVO PROVEEDOR
                    </a>
                </h2>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success mb-3">
                <p>{{ $message }}</p>
            </div>
        @endif

        <table id="table_id" class="table table-striped table-hover">
            <thead class="thead">
                <tr>
                    <th>ID</th>
                    <th>RUT</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Ciudad</th>
                    <th>Correo-E</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($providers as $provider)
                    <tr>
                        <td>{{ $provider->id }}</td>
                        <td>{{ $provider->rut }}</td>
                        <td>{{ $provider->name }}</td>
                        <td>{{ $provider->address }}</td>
                        <td>{{ $provider->city }}</td>
                        <td>{{ $provider->email }}</td>

                        <td>
                            <form action="{{ route('providers.destroy', $provider->id) }}" method="POST">
                                <a class="btn btn-sm btn-primary " href="{{ route('providers.show', $provider->id) }}">
                                    <i class="material-icons">visibility</i>
                                </a>
                                <a class="btn btn-sm btn-success" href="{{ route('providers.edit', $provider->id) }}">
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
@endsection
