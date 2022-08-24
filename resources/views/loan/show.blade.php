@extends('layouts.prestamo')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <h2>Prestamo # {{ $loan->id }}</h2>

                @if (!$loan->confirmed or !$loan->voucher or (new DateTime())->format('Y-m-d') > $loan->return)
                    <div class="row">
                        <div class="col text-left">
                            <h3 class="text-warning">Advertencias</h3>
                            <ul class="text-danger">
                                @if (!$loan->confirmed)
                                    <li>
                                        El préstamo no está confirmado
                                        <a class="btn btn-sm btn-link"
                                            href="{{ route('solucionar', ['option' => 'confirmar', 'loan' => $loan->id]) }}">SOLUCIONAR</a>
                                    </li>
                                @endif
                                @if (!$loan->voucher)
                                    <li>
                                        El comprobante firmado no está cargado
                                        <a class="btn btn-sm btn-link"
                                            href="{{ route('solucionar', ['option' => 'comprobante', 'loan' => $loan->id]) }}">SOLUCIONAR</a>
                                    </li>
                                @endif
                                @if ((new DateTime())->format('Y-m-d') > $loan->return)
                                    <li>
                                        El préstamo está vencido, debe comunicarse con el prestatario.
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                @endif

                <table class="table table-sm table-bordered text-left">
                    <tr>
                        <th class="table-primary" colspan="2">DATOS GENERALES : </th>
                    </tr>
                    <tr>
                        <th>Desde</th>
                        <td>{{ $loan->delivery }}</td>
                    </tr>
                    <tr>
                        <th>Hasta</th>
                        <td>{{ $loan->return }}</td>
                    </tr>
                    <tr>
                        <th>Tipo de Préstamo</th>
                        <td>
                            @if ($loan->user_id)
                                Préstamo a funcionario(a)
                            @endif
                            @if ($loan->student_id)
                                Préstamo a estudiante
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Comprobante</th>
                        <td>
                            @if ($loan->voucher)
                                <span class="badge badge-success">COMPROBANTE FIRMADO</span>
                                <a href="{{ asset($loan->voucher) }}" target="_blank">Ver</a>
                            @else
                                <span class="badge badge-danger">SIN COMPROBANTE</span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Estado</th>
                        <td>
                            @if ($loan->returned)
                                <span class="badge badge-info">DEVUELTO</span>
                            @else
                                <span class="badge badge-success">PRESTAMO ACTIVO</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Devolución</th>
                        <td>
                            {{ $loan->returned ?? 'NA' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Observaciones</th>
                        <td>
                            {{ $loan->observations ?? 'NA' }}
                        </td>
                    </tr>
                    <tr>
                        <th class="table-primary" colspan="2">PRESTATARIO : </th>
                    </tr>
                    <tr>
                        <th>Responsable</th>
                        <td>
                            @if ($loan->user_id)
                                {{ $loan->user_name }}
                            @endif
                            @if ($loan->student_id)
                                {{ $loan->proxy_name . ' ' . $loan->proxy_lastname1 . ' ' . $loan->proxy_lastname2 }}<br>
                                <small>
                                    {{ $loan->student_name . ' ' . $loan->student_lastname1 }}
                                    ({{ $curso }})
                                </small>
                            @endif
                        </td>
                    </tr>
                    @if ($loan->user_id)
                        <tr>
                            <th>Correo-E</th>
                            <td>
                                @if ($loan->user_id)
                                    {{ $loan->user_email }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Teléfono</th>
                            <td>
                                @if ($loan->user_id)
                                    {{ $loan->user_phone }}
                                @endif
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th class="table-primary" colspan="2">DETALLE DE PRESTAMO : </th>
                    </tr>
                    <tr>
                        <th>Producto/Equipo</th>
                        <th>Cantidad</th>
                    </tr>

                    <tr>
                        <td>{{ $loan->item }}</td>
                        <td>{{ $loan->qty * -1 }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
