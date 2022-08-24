@extends('layouts.inventario')

@section('template_title')
    Subida Masiva desde archivo Excel
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Importar Archivo Excel</div>
                    <div class="card-body">

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (session('fail'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('fail') }}
                            </div>
                        @endif

                        @if (isset($errors) && $errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif

                        @if (session()->has('failures'))
                            <table class="table table-danger">
                                <tr>
                                    <th>Fila</th>
                                    <th>Error</th>
                                    <th>Valor</th>
                                </tr>

                                @foreach (session()->get('failures') as $error)
                                    <tr>
                                        <td>{{ $error->row() }}</td>
                                        <td>
                                            <ul>
                                                @foreach ($error->errors() as $item)
                                                    <li>{{ $item }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            {{ $error->values()[$error->attribute()] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif

                        <form method="post" enctype="multipart/form-data" action=" {{ route('saveImport') }} ">
                            @csrf
                            <div class="form-group">
                                <input type="file" name="archivo" class="form-control"/><br>
                                <button type="submit" class="btn btn-primary float-right"> Importar </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
