@extends('layouts.user')

@section('title')
    Roles
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <h2>
                    Roles
                    
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
                            
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $rol)
                            <tr>
                                <td>{{ $rol->id }}</td>
                                <td>{{ $rol->name }}</td>                           

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
