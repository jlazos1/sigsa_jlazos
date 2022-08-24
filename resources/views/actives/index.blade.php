@extends('layouts.inventario')

@section('title')
    Activos
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <h2>
                    Activos
                    <a href=" {{ route('actives.create') }} " class="btn btn-primary mb-2 float-right ml-2">
                        Nuevo Activo
                    </a>
                    <a href=" {{ route('importActives')}} " class="btn btn-primary mb-2 float-right">
                        Carga Masiva (Excel)
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
                            <th>SKU</th>
                            <th>Item</th>
                            <th>Marca</th>
                            
                            <th>Serial Number</th>
                            <th>Ubicación</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($actives as $active)
                            <tr>
                                <td>{{ $active->sku }}</td>
                                <td>{{ $active->item }}</td>
                                <td>{{ $active->brand . ' - ' . $active->model }}</td>
                                <td>{{ $active->serial_number }}</td>
                                <td>{{ $active->place_name}}</td>
                                
                                <td>
                                    <form action="{{ route('actives.destroy', $active->id) }}" method="POST">
                                        <a class="btn btn-sm btn-primary "
                                            href=" {{ route('actives.show', $active->id) }}">
                                            <i class="material-icons">visibility</i>
                                        </a>
                                        <a class="btn btn-sm btn-success"
                                            href="{{ route('actives.edit', $active->id) }}">
                                            <i class="material-icons">edit</i>
                                        </a>
                                        <a class="btn btn-sm btn-info"
                                            href="{{ route('moveActives', $active->id) }}">
                                            <i class="material-icons">forward</i>
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
