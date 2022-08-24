@extends('layouts.prestamo')
@section('content')
    <div class="container">
        <div class="row bg-dark text-white mb-3 text-center">
            <div class="col-sm-3">
                <b>REPORTE GENERAL</b>
            </div>
            <div class="col-sm-3">
                TOTAL PRESTAMOS : {{ $report['total'] }}
            </div>
            <div class="col-sm-3">
                ACTIVOS : {{ $report['activos'] }}
            </div>
            <div class="col-sm-3">
                DEVUELTOS : {{ $report['devueltos'] }}
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h3>Lista maestra de préstamo de tablets</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>Estudiante</th>
                            <th>Curso</th>
                            <th>Préstamos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lista as $item)
                            @if (count($item->student->loans) > 0)
                                <tr>
                                    <td>{{ $item->student->name }}</td>
                                    <td>{{ $item->student->enrollment->course->name }}</td>
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
