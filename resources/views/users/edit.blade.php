@extends('layouts.user')

@section('title')
    Editar Usuario
@endsection

@section('content')
    <div class="container-fluid mb-3">
        <div class="row">
            <div class="col-md-12">
                <h2>Editar Usuario</h2>
                <form method="POST" action="{{ route('updateUser', $user->id) }}">
                    @csrf
                    <div class="form-group">
                        <label>Nombre</label>
                        <input class="form-control" type="text" name='name' value="{{ $user->name }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="box-footer mt20 mt-2">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
