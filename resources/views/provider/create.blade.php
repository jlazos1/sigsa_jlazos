@extends('layouts.inventario')

@section('template_title')
    Create Provider
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2>Proveedores</h2>

                <form method="POST" action="{{ route('providers.store') }}" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>RUT</label>
                        <input type="text" name='rut' class="form-control" value="{{ old('rut') ?? '' }}">
                        @error('rut')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>NOMBRE</label>
                        <input type="text" name='name' class="form-control" value="{{ old('name') ?? '' }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>DIRECCION</label>
                        <input type="text" name='address' class="form-control" value="{{ old('address') ?? '' }}">
                        @error('address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>CIUDAD</label>
                        <input type="text" name='city' class="form-control" value="{{ old('city') ?? '' }}">
                        @error('city')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>CORREO-E</label>
                        <input type="text" name='email' class="form-control" value="{{ old('email') ?? '' }}">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="box-footer mt20">
                        <button type="submit" class="btn btn-primary">Crear proveedor</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
