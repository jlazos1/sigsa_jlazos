@extends('layouts.prestamo')

@section('title', 'Reporte por Curso')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="{{ url()->previous() }}" class="btn btn-sm btn-info mb-3">Volver</a>
                <h3>Reporte Entrega/Devolución {{ $curso->name . " - Año: " . $anio }}</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>Estudiante</th>
                            <th>Préstamos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($lista))

                            @foreach ($lista as $item)
                                @if (count($item->student->loans) > 0)
                                    <tr>
                                        <td>
                                            <a
                                                href="{{ route('devolucion.estudiante', ['student_id' => $item->student->id]) }}">
                                                {{ $item->student->name }}
                                            </a>
                                        </td>
                                        <td>
                                            @foreach ($item->student->loans as $loan)
                                                @if ($loan->returned)
                                                    <span class="badge badge-info">
                                                        #{{ $loan->id }} - DEVUELTO
                                                    </span>
                                                @else
                                                    <span class="badge badge-success">
                                                        #{{ $loan->id }} - ACTIVO
                                                    </span>
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
