@extends('layouts.student')

@section('title')
    Usuarios
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

                        <form method="post" enctype="multipart/form-data" action=" {{ route('studentsSaveImport') }} ">
                            @csrf
                            <div class="form-group">
                                <input type="file" name="archivo" class="form-control" /><br>
                                <button type="submit" class="btn btn-primary float-right"> Importar </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
