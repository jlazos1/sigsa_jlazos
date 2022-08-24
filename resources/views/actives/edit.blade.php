@extends('layouts.inventario')

@section('template_title')
    Editar Activo
@endsection

@section('content')
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-12 mb-4">
                <h2>Editar Activo</h2>
                <form method="POST" action="{{ route('actives.update', $active->id) }}">
                    @csrf
                    @method("PUT")
                    <div class="form-group">
                        <label for="">Item</label>
                        <input class="form-control" type="text" name='item' value="{{ $active->item }}">
                        @error('item')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Marca</label>
                        <input class="form-control" type="text" name='brand' value="{{ $active->brand }}">
                        @error('brand')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Modelo</label>
                        <input class="form-control" type="text" name='model' value="{{ $active->model }}">

                        @error('model')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Número de Serie</label>
                        <input class="form-control" type="text" name='serial_number'
                            value="{{ $active->serial_number }}">

                        @error('serial_number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Departamento</label>
                        <input class="form-control" type="text" name='department' value="{{ $active->department }}">
                        @error('department')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Lugar de Almacenado</label>
                        <select name="place_id" id="place_id" class="form-control selectpicker" data-live-search="true"
                            required>
                            <option value="">Seleccione un lugar</option>
                            @foreach ($places as $place)
                                <option value="{{ $place->id }}" @if ($place->id == $active->place_id) selected @endif>
                                    {{ $place->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label>Rut de Proveedor</label>
                        <input class="form-control" type="text" name='rut_provider'
                            value="{{ $bill->transmitterRut }}">
                        @error('rut_provider')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Número de Factura</label>
                        <input class="form-control" type="number" name='bill_number' value="{{ $bill->number }}">
                        @error('bill_number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Fecha de Factura</label>
                        <input class="form-control" type="date" name='bill_date' value="{{ $bill->date }}">
                        @error('bill_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Observaciones</label>
                        <input class="form-control" type="text" name='observation' value="{{ $active->observation }}">
                        @error('observation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="box-footer mt20">
                        <button type="submit" class="btn btn-primary">Actualizar Activo</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
