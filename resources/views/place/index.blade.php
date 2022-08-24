@extends('layouts.inventario')

@section('title')
    Ubicaciones
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 mt-3">
                <h2>
                    Ubicaciones (Bodegas, lugares)
                    <a href="{{ route('places.create') }}" class="btn btn-primary btn-sm float-right">
                        Nuevo
                    </a>
                </h2>
                <p>
                    Las ubicaciones son las bodegas, oficinas, salas o lugares donde se ubica el mobiliario
                    . De esa forma es posible obtener informes de inventarios por ubicaciones.
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                <table class="table table-striped table-hover" id="table_id">
                    <thead class="thead table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($places as $place)
                            <tr>
                                <td>{{ $place->id }}</td>
                                <td>{{ $place->code }}</td>
                                <td>{{ $place->name }}</td>
                                <td>
                                    <form action="{{ route('places.destroy', $place->id) }}" method="POST">
                                        <a class="btn btn-sm btn-primary " href="{{ route('places.show', $place->id) }}">
                                            <i class="material-icons">visibility</i>
                                        </a>
                                        <a class="btn btn-sm btn-success" href="{{ route('places.edit', $place->id) }}">
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
