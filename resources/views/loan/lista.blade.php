@extends('layouts.prestamo')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col text-center">
                <h1>Lista de Préstamos</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table id="table_id" class="table table-bordered table-sm">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>#</th>
                            <th>Tipo</th>
                            <th>Desde</th>
                            {{-- <th>Hasta</th> --}}
                            <th>Prestatario</th>
                            <th>Estado</th>
                            <th>Comprobante</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($loans as $loan)
                            <tr>
                                <td>{{ $loan->id }}</td>
                                <td>
                                    @if ($loan->user_id)
                                        <span class="badge badge-info">PRESTAMO A FUNCIONARIO</span>
                                    @endif
                                    @if ($loan->student_id)
                                        <span class="badge badge-warning">PRESTAMO A ESTUDIANTE</span>
                                    @endif
                                </td>
                                <td>{{ $loan->delivery }}</td>
                                {{-- <td class="{{ (new DateTime())->format('Y-m-d') > $loan->return ? 'text-danger' : '' }}">
                                    {{ $loan->return }}
                                </td> --}}
                                @if ($loan->user_id)
                                    <td>{{ $loan->user->name }}</td>
                                @endif
                                @if ($loan->student_id)
                                    <td>{{ $loan->student->name }}</td>
                                @endif
                                <td>
                                    @if ($loan->returned)
                                        <span class="badge badge-info center">
                                            DEVUELTO <br>
                                            {{ (new DateTime($loan->returned))->format('d-m-Y H:i:s') }}
                                        </span>
                                    @else
                                        @if ($loan->confirmed)
                                            <span class="badge badge-success">PRESTAMO ACTIVO</span>
                                        @else
                                            <span class="badge badge-warning">FALTA CONFIRMACION</span>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($loan->voucher)
                                        <span class="badge badge-success">FIRMADO</span>
                                    @else
                                        <span class="badge badge-danger">SIN FIRMAR</span>
                                    @endif
                                </td>
                                <td>
                                    <a title="Ver préstamo" href="{{ route('prestamo.ver', ['id' => $loan->id]) }}"
                                        class="btn btn-sm" title="Ver préstamo">
                                        <i class="material-icons">visibility</i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
