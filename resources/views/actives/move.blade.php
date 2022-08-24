@extends('layouts.inventario')

@section('title')
    Mover Activos
@endsection

@section('content')
    <div class="content container-fluid">
        <div class="row"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">
                                <h3>Moverá el siguiente Activo</h3>
                            </span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('actives.index') }}"> Volver </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <strong>SKU:</strong>
                            {{ $active->sku }}
                        </div>

                        <div class="form-group">
                            <strong>Item:</strong>
                            {{ $active->item . ' ' . $active->brand . ' - ' . $active->model }}
                        </div>

                        <div class="form-group">
                            <strong>Número de serie:</strong>
                            {{ $active->serial_number }}
                        </div>

                        <div class="form-group">
                            <strong>Desde:</strong>
                            {{ $nombre_lugar }}
                        </div>

                        <div class="d-flex justify-content-center">
                            <img src="{{ asset('img/outline_arrow_downward_black_48dp.png') }}" alt="">
                            <img src="{{ asset('img/outline_arrow_downward_black_48dp.png') }}" alt="">
                            <img src="{{ asset('img/outline_arrow_downward_black_48dp.png') }}" alt="">

                        </div>

                        <div class="form-group">
                            <form action="{{ route('saveMove', $active->id)}}">
                                <select name="place_id" id="place_id" class="mt-2 form-control selectpicker"
                                    data-live-search="true" required>
                                    <option value="0">Seleccione un lugar</option>
                                    @foreach ($places as $place)
                                        <option value="{{ $place->id }}"> {{ $place->name }}</option>
                                    @endforeach
                                </select>
                                @error('place_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <button type="submit" class="btn btn-primary float-right mt-2">Mover</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
