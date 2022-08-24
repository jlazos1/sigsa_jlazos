@extends('layouts.inventario')

@section('title')
    Documento de Salida
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h3>Documento de Salida</h3>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong>Recuerde : </strong>
                    Documento de Salida registra todos los productos que salen de
                    las dependencias del establecimiento.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="row">
                    <div class="col">
                        <h5>DATOS DEL RECEPTOR</h5>
                    </div>
                </div>
                <form method="POST" action="{{ route('documents.store.exit') }}">
                    @csrf
                    @method("POST")
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>RUT</label>
                            <div class="input-group">
                                <input id="receiverRut" name="receiverRut" type="text"
                                    class="form-control @error('receiverRut') is-invalid @enderror"
                                    placeholder="123456789-0" value="{{ old('receiverRut') ?? '' }}">
                                <div class="input-group-append">
                                    <button class="btn btn-success" type="button" id="search" onclick="searchProvider()">
                                        Buscar
                                    </button>
                                </div>
                            </div>
                            @error('receiverRut')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-8 text-sm">
                            <div id="receiver"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Tipo de Documento</label>
                            <select class="form-control selectpicker" name="documentType" id="documentType"
                                onchange="searchDocument()">
                                <option value="">Seleccione...</option>
                                <option value="GUIA DE DESPACHO"
                                    {{ old('documentType') == 'GUIA DE DESPACHO' ? 'selected' : '' }}>
                                    GUIA DE DESPACHO
                                </option>
                                <option value="OTRO" {{ old('documentType') == 'OTRO' ? 'selected' : '' }}>
                                    OTRO
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Glosa <small>(Ejemplos: Traslado a servicio técnico, Donación, Mermas, etc.
                                    )</small></label>
                            <input type="text" class="form-control @error('gloss') is-invalid @enderror" name="gloss"
                                value="{{ old('gloss') ?? '' }}">
                            @error('gloss')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label>Fecha</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" name="date"
                                value="{{ old('date') ?? '' }}">
                            @error('date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label>Neto</label>
                            <input type="number" class="form-control @error('net') is-invalid @enderror" name="net" id="net"
                                value="{{ old('net') ?? '' }}" onblur="calcTotal()">
                            @error('net')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label>Impto (IVA)</label>
                            <input type="number" class="form-control @error('tax') is-invalid @enderror" name="tax" id="tax"
                                value="{{ old('tax') ?? '' }}">
                            @error('tax')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label>Total</label>
                            <input type="number" class="form-control @error('total') is-invalid @enderror" name="total"
                                id="total" value="{{ old('total') ?? '' }}">
                            @error('total')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="alert alert-danger" hidden id="existeDocumento">
                                <b>ADVERTENCIA : </b> Este documento ya existe en nuestra base de datos, por favor
                                verifique RUT emisor,
                                tipo y número de documento.
                            </div>
                            <button class="btn form-control btn-primary" name="button1" id="button1" value="1">
                                GUARDAR Y SALIR
                            </button>
                            <button class="btn form-control btn-info mt-1" name="button2" id="button2" value="1">
                                GUARDAR Y AGREGAR PRODUCTOS
                            </button>
                        </div>
                    </div>
                </form>

                @livewire('form-provider-component')

            </div>
        </div>
    </div>


    @push('script')
        <script>
            function searchProvider() {
                let rut = document.querySelector("#receiverRut").value;
                const receiver = document.querySelector("#receiver");
                $.get("/getProvider/" + rut, function(data) {
                    if (data) {
                        receiver.innerHTML = "<b class='text-success'>ENCONTRADO</b><br>";
                        receiver.innerHTML += data.name + "<br>";
                        receiver.innerHTML += data.address + ", " + data.city
                    } else {
                        receiver.innerHTML = "<b class='text-danger'>NO EXISTE PROVEEDOR</b><br>";
                        receiver.innerHTML += "¿Desea agregar nuevo proveedor?<br>";
                        receiver.innerHTML +=
                            "<button class='btn btn-sm btn-info' class='btn btn-primary' onclick='openModalProvider()'>AGREGAR EMISOR</button>";
                    }
                });
            }

            function openModalProvider() {
                $("#modalAddProvider").modal("show");
                receiver.innerHTML = "";
            }

            function calcTotal() {
                let net = document.querySelector("#net");
                let tax = document.querySelector("#tax");
                let total = document.querySelector("#total");
                tax.value = net.value * 0.19;
                total.value = parseInt(net.value) + parseInt(tax.value);
            }

            function searchDocument() {
                let receiverRut = document.querySelector("#receiverRut").value;
                let documentType = document.querySelector("#documentType").value;
                let number = document.querySelector("#number").value;
                $.get("/getDocument/" + number + "/" + documentType + "/" + receiverRut, function(data) {
                    if (data) {
                        document.querySelector("#button1").disabled = true;
                        document.querySelector("#button2").disabled = true;
                        document.querySelector("#existeDocumento").hidden = false;
                    } else {
                        document.querySelector("#button1").disabled = false;
                        document.querySelector("#button2").disabled = false;
                        document.querySelector("#existeDocumento").hidden = true;
                    }
                });
            }

            Livewire.on("addLineFocus", function() {
                document.querySelector("#detailProduct").value = "";
                document.querySelector("#detailProduct").focus();
            });
        </script>
    @endpush
@endsection
