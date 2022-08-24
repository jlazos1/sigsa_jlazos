@extends('layouts.user')

@section('title')
    Usuario
@endsection

@section('content')
    <div class="container-fluid mt-3 mb-3">
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-primary mb-3" href="{{ route('userIndex') }}"> Volver </a>
                
                <div class="form-group">
                    <strong>Nombre:</strong>
                    {{ $user->name }}
                </div>
                <div class="form-group">
                    <strong>Email:</strong>
                    {{ $user->email }}
                </div>
            </div>
        </div>
    </div>
@endsection
