@extends('layouts.inventario')

@section('template_title')
    Update Provider
@endsection

@section('content')
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Proveedores</h2>
            @includeif('partials.errors')
            <form method="POST" action="{{ route('providers.update', $provider->id) }}" role="form"
                enctype="multipart/form-data">
                @method("PUT")
                @csrf
                <div class="form-group">
                    <label>RUT</label>
                    <input type="text" name='rut' class="form-control" value="{{ $provider->rut }}">
                    @error('rut')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>NOMBRE</label>
                    <input type="text" name='name' class="form-control" value="{{ $provider->name }}">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>DIRECCION</label>
                    <input type="text" name='address' class="form-control" value="{{ $provider->address }}">
                    @error('address')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>CIUDAD</label>
                    <input type="text" name='city' class="form-control" value="{{ $provider->city }}">
                    @error('city')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>CORREO-E</label>
                    <input type="text" name='email' class="form-control" value="{{ $provider->email }}">
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="box-footer mt20">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>

            </form>
        </div>
    </div>
@endsection
