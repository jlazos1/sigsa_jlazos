@extends('layouts.inventario')

{{-- @section('title')
    Actualiza Documento
@endsection --}}

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Actualiza Documento</h3>
                @includeif('partials.errors')

                <form method="POST" action="{{ route('documents.update', $document->id) }}">
                    @method("PUT")
                    @csrf
                    <div class="row">

                        <div class="col-md-12">
                            <h4>Antecedes del Emisor</h4>
                        </div>
                        <div class="form-group col-md-4">
                            <label>RUT</label>
                            <input type="text" class="form-control @error('transmitterRut') is-invalid @enderror"
                                name="transmitterRut" value="{{ $document->transmitterRut ?? old('transmitterRut') }}">
                            @error('transmitterRut')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-8">
                            <label>Nombre</label>
                            <input type="text" class="form-control @error('transmitterName') is-invalid @enderror"
                                name="transmitterName" value="{{ $document->transmitterName ?? old('transmitterName') }}">
                            @error('transmitterName')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label>Dirección</label>
                            <input type="text" class="form-control @error('transmitterAddress') is-invalid @enderror"
                                name="transmitterAddress"
                                value="{{ $document->transmitterAddress ?? old('transmitterAddress') }}">
                            @error('transmitterAddress')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label>Ciudad</label>
                            <input type="text" class="form-control @error('transmitterCity') is-invalid @enderror"
                                name="transmitterCity" value="{{ $document->transmitterCity ?? old('transmitterCity') }}">
                            @error('transmitterCity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label>Correo-E</label>
                            <input type="email" class="form-control @error('transmitterEmail') is-invalid @enderror"
                                name="transmitterEmail"
                                value="{{ $document->transmitterEmail ?? old('transmitterEmail') }}">
                            @error('transmitterEmail')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <h4>Antecedes del Receptor</h4>
                        </div>
                        <div class="form-group col-md-4">
                            <label>RUT</label>
                            <input type="text" class="form-control @error('receiverRut') is-invalid @enderror"
                                name="receiverRut" value="{{ $document->receiverRut ?? old('receiverRut') }}">
                            @error('receiverRut')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-8">
                            <label>Nombre</label>
                            <input type="text" class="form-control @error('receiverName') is-invalid @enderror"
                                name="receiverName" value="{{ $document->receiverName ?? old('receiverName') }}">
                            @error('receiverName')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label>Dirección</label>
                            <input type="text" class="form-control @error('receiverAddress') is-invalid @enderror"
                                name="receiverAddress"
                                value="{{ $document->receiverAddress ?? old('receiverAddress') }}">
                            @error('receiverAddress')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label>Ciudad</label>
                            <input type="text" class="form-control @error('receiverCity') is-invalid @enderror"
                                name="receiverCity" value="{{ $document->receiverCity ?? old('receiverCity') }}">
                            @error('receiverCity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label>Correo-E</label>
                            <input type="email" class="form-control @error('receiverEmail') is-invalid @enderror"
                                name="receiverEmail" value="{{ $document->receiverEmail ?? old('receiverEmail') }}">
                            @error('receiverEmail')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <h4>Documento</h4>
                            <div class="alert alert-danger" hidden id="existeDocumento">
                                <b>ADVERTENCIA : </b> Este documento ya existe en nuestra base de datos, por favor
                                verifique RUT emisor,
                                tipo y número de documento.
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Tipo Movimiento</label>
                            <select class="form-control selectpicker" name="type" id="type">
                                <option value="ENTRADA" {{ $document->type == 'ENTRADA' ? 'selected' : '' }}>
                                    ENTRADA
                                </option>
                                <option value="SALIDA" {{ $document->type == 'SALIDA' ? 'selected' : '' }}>
                                    SALIDA
                                </option>
                            </select>
                        </div>

                        <div class="col-md-8"></div>

                        <div class="form-group col-md-4">
                            <label>Tipo de Documento</label>
                            <select class="form-control selectpicker" name="documentType" id="documentType"
                                onchange="searchDocument()">
                                <option value="">Seleccione...</option>
                                <option value="FACTURA" {{ $document->documentType == 'FACTURA' ? 'selected' : '' }}>
                                    FACTURA
                                </option>
                                <option value="BOLETA" {{ $document->documentType == 'BOLETA' ? 'selected' : '' }}>
                                    BOLETA
                                </option>
                                <option value="GUIA DE DESPACHO"
                                    {{ $document->documentType == 'GUIA DE DESPACHO' ? 'selected' : '' }}>
                                    GUIA DE DESPACHO
                                </option>
                                <option value="OTRO" {{ $document->documentType == 'OTRO' ? 'selected' : '' }}>
                                    OTRO
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Número de Documento</label>
                            <input type="text" class="form-control @error('number') is-invalid @enderror" name="number"
                                id="number" value="{{ $document->number ?? old('number') }}" onblur="searchDocument()">
                            @error('number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label>Fecha</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" name="date"
                                value="{{ $document->date ?? old('date') }}">
                            @error('date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label>Neto</label>
                            <input type="number" class="form-control @error('net') is-invalid @enderror" name="net" id="net"
                                value="{{ $document->net ?? old('net') }}" onblur="calcTotal()">
                            @error('net')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label>Impto (IVA)</label>
                            <input type="number" class="form-control @error('tax') is-invalid @enderror" name="tax" id="tax"
                                value="{{ $document->tax ?? old('tax') }}">
                            @error('tax')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label>Total</label>
                            <input type="number" class="form-control @error('total') is-invalid @enderror" name="total"
                                id="total" value="{{ $document->total ?? old('total') }}">
                            @error('total')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-4">
                            <button class="btn form-control btn-primary mb-2">
                                GUARDAR CAMBIOS
                            </button>
                            <a class="btn form-control btn-warning mb-2"
                                href="{{ route('details.add', ['documentId' => $document->id]) }}">
                                IR A MODIFICAR PRODUCTOS
                            </a>
                            <a class="btn form-control btn-secondary" href="{{ route('documents.index') }}">
                                CANCELAR
                            </a>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            function calcTotal() {
                let net = document.querySelector("#net");
                let tax = document.querySelector("#tax");
                let total = document.querySelector("#total");
                tax.value = net.value * 0.19;
                total.value = parseInt(net.value) + parseInt(tax.value);
            }
        </script>
    @endpush
@endsection
