@extends('layouts.inventario')

@section('template_title')
    Nuevo Activo
@endsection

@section('content')
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-12 mb-4">
                <h2>Nuevo Activo</h2>
                <form method="POST" action="{{ route('actives.store') }}">
                    @csrf
                    @method("POST")
                    <div class="form-group">
                        <label for="">Item</label>
                        <input class="form-control" type="text" name='item' value="{{ old('item') ?? '' }}">
                        @error('item')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                   
                    <div class="form-group">
                        <label>Marca</label>
                        <input class="form-control" type="text" name='brand' value="{{ old('brand') ?? '' }}">
                        @error('brand')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Modelo</label>
                        <input class="form-control" type="text" name='model' value="{{ old('model') ?? '' }}">

                        @error('model')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Número de Serie</label>
                        <input class="form-control" type="text" name='serial_number' value="{{ old('serial_number') ?? '' }}">

                        @error('serial_number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Departamento</label>
                        <input class="form-control" type="text" name='department' value="{{ old('department') ?? '' }}">
                        @error('department')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Lugar de Almacenado</label>
                        <select name="place_id" id="place_id" class="form-control selectpicker" data-live-search="true" required>
                            <option value="0">Seleccione un lugar</option>
                            @foreach ($places as $place)
                                <option value="{{ $place->id }}"> {{ $place->name }}</option>
                            @endforeach
                        </select>
                        @error('place_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label>Rut de Proveedor</label>
                        <input class="form-control" type="text" name='rut_provider' value="{{ old('rut_provider') ?? '' }}">
                        @error('rut_provider')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Número de Factura</label>
                        <input class="form-control" type="number" name='bill_number' value="{{ old('bill_number') ?? '' }}">
                        @error('bill_number')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Fecha de Factura</label>
                        <input class="form-control" type="date" name='bill_date' value="{{ old('bill_date') ?? '' }}">
                        @error('bill_date')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Observaciones</label>
                        <input class="form-control" type="text" name='observation'
                            value="{{ old('observation') ?? '' }}">
                        @error('observation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="box-footer mt20">
                        <button type="submit" class="btn btn-primary">Crear Activo</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
