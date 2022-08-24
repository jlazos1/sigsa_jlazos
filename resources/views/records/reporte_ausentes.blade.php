@extends('layouts.asistencia')
@section('content')

<div class="container">
    <div class="row">
        <div class="col">
            <h2>Informe de Inasistencias</h2>
            <form action="{{ route('reporte.ausentes') }}" method="post">
                @csrf
                @method("POST")
                <div class="form-group">
                    <label>Curso</label>
                    <select class="form-control" name="curso">
                        <option value="todos">Todos</option>
                        @foreach ($cursos as $item)
                        <option value="{{$item->departament}}" {{$item->departament == $curso ? "selected":""}}>
                            {{$item->departament}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Fecha</label>
                    <input class="form-control" type="date" name="fecha"
                        value="{{ old("fecha") ?? (new DateTime())->format("Y-m-d") }}">
                </div>
                <div class="form-group mt-3">
                    <button class="btn btn-success">Buscar</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col">

        </div>
    </div>
</div>

@endsection
