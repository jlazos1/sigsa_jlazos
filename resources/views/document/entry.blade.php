@extends('layouts.inventario')

@section('title')
    Documento de Entrada
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h3>Documento de Entrada</h3>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Recuerde : </strong> Documento de entrada registra todos los documentos que hacen ingreso de
                    mobiliario
                    a las dependencias del establecimiento.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('documents.store.entry') }}">
                    @csrf
                    @method("POST")
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>RUT (Emisor)</label>
                            <div class="input-group">
                                <input id="transmitterRut" name="transmitterRut" type="text"
                                    class="form-control @error('transmitterRut') is-invalid @enderror"
                                    placeholder="123456789-0" value="{{ old('transmitterRut') ?? '' }}">
                                <div class="input-group-append">
                                    <button class="btn btn-success" type="button" id="search" onclick="searchProvider()">
                                        Buscar
                                    </button>
                                </div>
                            </div>
                            @error('transmitterRut')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-8 text-sm">
                            <div id="transmitter"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Tipo de Documento</label>
                            <select class="form-control selectpicker" name="documentType" id="documentType"
                                onchange="searchDocument()">
                                <option value="">Seleccione...</option>
                                <option value="FACTURA" {{ old('documentType') == 'FACTURA' ? 'selected' : '' }}>
                                    FACTURA
                                </option>
                                <option value="BOLETA" {{ old('documentType') == 'BOLETA' ? 'selected' : '' }}>
                                    BOLETA
                                </option>
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
                            <label>Número de Documento</label>
                            <input type="text" class="form-control @error('number') is-invalid @enderror" name="number"
                                id="number" value="{{ old('number') ?? '' }}" onblur="searchDocument()">
                            @error('number')
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
                let rut = document.querySelector("#transmitterRut").value;
                const transmitter = document.querySelector("#transmitter");
                $.get("/getProvider/" + rut, function(data) {
                    if (data) {
                        transmitter.innerHTML = "<b class='text-success'>ENCONTRADO</b><br>";
                        transmitter.innerHTML += data.name + "<br>";
                        transmitter.innerHTML += data.address + ", " + data.city
                    } else {
                        transmitter.innerHTML = "<b class='text-danger'>NO EXISTE PROVEEDOR</b><br>";
                        transmitter.innerHTML += "¿Desea agregar nuevo proveedor?<br>";
                        transmitter.innerHTML +=
                            "<button class='btn btn-sm btn-info' class='btn btn-primary' onclick='openModalProvider()'>AGREGAR EMISOR</button>";
                    }
                });
            }

            function openModalProvider() {
                $("#modalAddProvider").modal("show");
                transmitter.innerHTML = "";
            }

            function calcTotal() {
                let net = document.querySelector("#net");
                let tax = document.querySelector("#tax");
                let total = document.querySelector("#total");
                tax.value = net.value * 0.19;
                total.value = parseInt(net.value) + parseInt(tax.value);
            }

            function searchDocument() {
                let transmitterRut = document.querySelector("#transmitterRut").value;
                let documentType = document.querySelector("#documentType").value;
                let number = document.querySelector("#number").value;
                $.get("/getDocument/" + number + "/" + documentType + "/" + transmitterRut, function(data) {
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
