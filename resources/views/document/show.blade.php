@extends('layouts.inventario')

@section('title', 'Vista de Documento')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-2">
                <a class="btn btn-link" href="{{ url()->previous() }}">Volver</a>
                <table class="table table-sm table-bordered">
                    <tr>
                        <th class="table-dark" colspan="6">
                            <h3>Documento N°{{ $document->number }}</h3>
                        </th>
                    </tr>
                    <tr>
                        <th>Tipo de Movimiento</th>
                        <td colspan="5">
                            <span class="badge badge-success">
                                {{ $document->type }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Tipo de Documento</th>
                        <td colspan="5">
                            <span class="badge badge-info">
                                {{ $document->documentType }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Número</th>
                        <td colspan="5">{{ $document->number }}</td>
                    </tr>
                    <tr>
                        <th>Fecha</th>
                        <td colspan="5">{{ (new DateTime($document->date))->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <th>Neto</th>
                        <td colspan="5">{{ number_format($document->net, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Impuesto</th>
                        <td colspan="5">{{ number_format($document->tax, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td colspan="5">{{ number_format($document->total, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th class="table-dark" colspan="6">Emisor</th>
                    </tr>
                    <tr>
                        <th>RUT</th>
                        <td>{{ $document->transmitterRut }}</td>
                        <th>Nombre</th>
                        <td colspan="4">{{ $document->transmitterName }}</td>
                    </tr>
                    <tr>
                        <th>Dirección</th>
                        <td>{{ $document->transmitterAddress }}</td>
                        <th>Ciudad</th>
                        <td>{{ $document->transmitterCity }}</td>
                        <th>Correo-E</th>
                        <td>{{ $document->transmitterEmail }}</td>
                    </tr>
                    <tr>
                        <th class="table-dark" colspan="6">Receptor</th>
                    </tr>
                    <tr>
                        <th>RUT</th>
                        <td>{{ $document->receiverRut }}</td>
                        <th>Nombre</th>
                        <td colspan="4">{{ $document->receiverName }}</td>
                    </tr>
                    <tr>
                        <th>Dirección</th>
                        <td>{{ $document->receiverAddress }}</td>
                        <th>Ciudad</th>
                        <td>{{ $document->receiverCity }}</td>
                        <th>Correo-E</th>
                        <td>{{ $document->receiverEmail }}</td>
                    </tr>
                    <tr>
                        <th class="table-dark" colspan="6">Productos</th>
                    </tr>

                    @foreach ($document->details as $item)
                        <tr>
                            <td colspan="{{ $document->type == 'ENTRADA' ? 2 : 3 }}" class="text-center">
                                {!! $item->product->name . '<br><small>SKU :' . $item->product->sku . '</small>' !!}</td>
                            @if ($document->type == 'ENTRADA')
                                <td>{!! $item->place->name . '<br><small>COD : ' . $item->place->code . '</small>' !!}</td>
                            @endif
                            <td class="text-center">{{ $item->qty }}</td>
                            <td class="text-right">{{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="text-right">
                                {{ number_format($item->qty * $item->price, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach

                </table>

                <table id="table_id" class="table table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Ubicación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($actives))
                            @foreach ($actives as $active)
                                <tr>
                                    <td>
                                        {{ $active->item . ' - ' . $active->brand . ' - ' . $active->model . ' - SKU: ' . $active->sku }}
                                    </td>
                                    <td>
                                        {{ $active->nombre_lugar}}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="row">
                    <div class="col text-center">
                        <a class="btn btn-primary mb-3" href="{{ url()->previous() }}">
                            Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
