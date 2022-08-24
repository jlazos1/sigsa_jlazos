@extends('layouts.inventario')

@section('title')
    Agregar Productos
@endsection

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col">
                <h3>
                    Agregar Productos
                </h3>
                @if ($document->type == 'ENTRADA')
                    <label class="badge badge-success">DOCUMENTO DE ENTRADA</label>
                @endif
                @if ($document->type == 'SALIDA')
                    <label class="badge badge-warning"> DOCUMENTO DE SALIDA</label>
                @endif
                <br>
                <button class="btn btn-sm btn-primary mb-2" type="button" data-toggle="collapse"
                    data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    DOCUMENTO N°{{ $document->number }} - {{ $document->transmitterName }}
                    GLOSA : {{ $document->gloss }}
                </button>
                <div class="collapse mb-3" id="collapseExample">
                    <div class="card card-body">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th>GLOSA</th>
                                <td>{{ $document->gloss }}</td>
                            </tr>
                            <tr>
                                <th>FECHA</th>
                                <td>{{ $document->date }}</td>
                            </tr>
                            <tr>
                                <th>NÚMERO</th>
                                <td>{{ $document->number }}</td>
                            </tr>
                            <tr>
                                <th>TIPO</th>
                                <td>{{ $document->documentType }}</td>
                            </tr>
                            <tr>
                                <th>MOVIMIENTO</th>
                                <td>{{ $document->type }}</td>
                            </tr>
                            <tr>
                                <th>RUT</th>
                                <td>{{ $document->transmitterRut }}</td>
                            </tr>
                            <tr>
                                <th>NOMBRE</th>
                                <td>{{ $document->transmitterName }}</td>
                            </tr>
                            <tr>
                                <th>DIRECCIÓN</th>
                                <td>{{ $document->transmitterAddress . ' ' . $document->transmitterCity }}</td>
                            </tr>
                            <tr>
                                <th>NETO</th>
                                <td>{{ number_format($document->net, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>IMPUESTO</th>
                                <td>{{ number_format($document->tax, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>TOTAL</th>
                                <td>{{ number_format($document->total, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <form class="row" action="{{ route('details.store') }}" method="POST">
            @method("POST")
            @csrf
            <input type="hidden" name="document_id" value="{{ $document->id }}">
            <div class="form-group col-md-4">
                <label>Producto</label>
                <select name="product_id" id="product_id" data-live-search="true" class="form-control selectpicker"
                    required="required" onchange="searchProduct(this.value)">
                    <option value="">Seleccione...</option>
                    @foreach ($products as $p)
                        <option value="{{ $p->id }}" data-subtext="{{ $p->sku }}">
                            {{ $p->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-1">
                <label>Cantidad</label>
                <input class="form-control" type="number" id="qty" name="qty" value="1" onblur="calcTotal()"
                    onchange="calcTotal()">
            </div>
            <div class="form-group col-md-2">
                <label>Precio</label>
                <input class="form-control" type="number" id="price" name="price">
            </div>
            <div class="form-group col-md-2">
                <label>Total</label>
                <input class="form-control" type="number" id="total" name="total">
            </div>
            @if ($document->type == 'ENTRADA')
                <div class="form-group col-md-2">
                    <label>Ubicación</label>
                    <select name="place_id" id="place_id" class="form-control selectpicker" required>
                        <option value="">Seleccione...</option>
                        @foreach ($places as $place)
                            <option value="{{ $place->id }}" data-subtext="{{ $place->code }}">
                                {{ $place->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
            <div class="form-group col-md-1">
                <label></label><br>
                <button class="btn btn-sm btn-primary mt-2">
                    <span class="material-icons">add</span>
                </button>
            </div>
        </form>

        <div class="row">
            <div class="col">
                <table class="table table-sm table-bordered table-hovered">
                    <thead class="table-info">
                        <tr>
                            <th class="text-center">Producto</th>
                            <th class="text-center">Cant</th>
                            <th class="text-center">Precio</th>
                            @if ($document->type == 'ENTRADA')
                                <th class="text-center">Ubicación</th>
                            @endif
                            <th class="text-center">Total</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($details)
                            @foreach ($details as $detail)
                                <tr>
                                    <td>
                                        {{ $detail->product->name }}<br>
                                        {!! '<small>SKU : ' . $detail->product->sku . '</small>' !!}
                                    </td>
                                    <td class="text-center">
                                        {{ number_format($detail->qty, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        $ {{ number_format($detail->price, 0, ',', '.') }}
                                    </td>
                                    @if ($document->type == 'ENTRADA')
                                        <td class="text-center">
                                            {{ $detail->place->code }}
                                        </td>
                                    @endif
                                    <td class="text-center">
                                        $ {{ number_format($detail->price * $detail->qty, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('details.destroy', $detail->id) }}" method="POST">
                                            @method("DELETE")
                                            @csrf
                                            <button class="btn btn-sm">
                                                <i class="material-icons">delete</i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col text-center">
                <h3>Total $ {{ number_format($total, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            function searchProduct(productId) {
                $.get("/getProduct/" + productId, function(product) {
                    document.querySelector("#price").value = product.priceBuy;
                    calcTotal();
                });
            }

            function calcTotal() {
                let price = document.querySelector("#price").value;
                let qty = document.querySelector("#qty").value;
                document.querySelector("#total").value = qty * price;
            }
        </script>
    @endpush
@endsection
