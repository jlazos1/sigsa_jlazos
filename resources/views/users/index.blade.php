@extends('layouts.user')

@section('title')
    Usuarios
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <h2>
                    Usuarios
                    
                </h2>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success mb-2">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                <table id="table_id" class="table table-striped table-hover">
                    <thead class="thead">
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <a href=" {{ route('showUser', $user->id) }} " class="btn"> Ver </a>
                                    <a href=" {{ route('editUser', $user->id) }} " class="btn">Editar</a>  
                                    <a href=" {{ route('permissionsUser', $user->id) }} " class="btn">Permisos</a>  
                                </td>                           

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
