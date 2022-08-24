@extends('layouts.simple')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h1>Resultado de elecciones</h1>
            <h3>Mejor compañero(a)</h3>
            <form method="POST" action="{{ route('elecciones.resultados') }}">
                @method("POST")
                @csrf
                <div class="form-group">
                    <label>Seleccione Curso</label>
                    <select name="curso" class="form-control">
                        <option value="">Seleccione...</option>
                        @foreach ($cursos as $item)
                        <option value="{{$item->departament}}" {{ ($curso == $item->departament) ? "selected":"" }}>
                            {{$item->departament}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-lg mt-2">BUSCAR</button>
                </div>
            </form>
        </div>
    </div>
    @if ($resultado)
    <div class="row">
        <div class="col">
            <table class="table table-sm table-bordered mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>Estudiante</th>
                        <th>Votos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resultado as $item)
                    <tr>
                        <td>{{$item->name}}</td>
                        <td>{{$item->votos}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
