<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="form-group col-md-4">
                <label for="">Tipo de Documento</label>
                <select class="form-control" wire:model="documentType" required>
                    <option value="FACTURA">FACTURA</option>
                    <option value="BOLETA">BOLETA</option>
                    <option value="GUIA DE DESPACHO">GUIA DE DESPACHO</option>
                    <option value="OTRO">OTRO</option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="">Número de Documento</label>
                <input type="text" class="form-control" wire:model="number" required>
            </div>
            <div class="form-group col-md-4">
                <label for="">Fecha</label>
                <input type="date" class="form-control" wire:model="date" required>
            </div>
            <div class="form-group col-md-4">
                <label for="">RUT (Emisor)</label>
                <div class="input-group">
                    <input id="transmitterRut" wire:model="transmitterRut" type="text" class="form-control"
                        placeholder="123456789-0">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="search" onclick="searchProvider()">
                            Buscar
                        </button>
                    </div>
                </div>
            </div>

            <div class="form-group col-md-8 text-sm">
                <div id="transmitter"></div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="row">
            <div class="col">
                <legend>Agregar mobiliario / productos</legend>
                <div class="row">
                    <div class="form-group col-md-4" wire:ignore>
                        <label>Producto / SKU</label>
                        <select class="form-control selectpicker" data-live-search="true" wire:model="detailProduct"
                            id="detailProduct" wire:change="searchProduct">
                            <option value="">Seleccione...</option>
                            @foreach ($products as $p)
                                <option value="{{ $p->id }}" data-subtext="SKU : {{ $p->sku }}">
                                    {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-1">
                        <label>Cantidad</label>
                        <input type="text" class="form-control" wire:model="detailQty" id="detailQty"
                            wire:blur="totalLine">
                    </div>
                    <div class="form-group col-md-2">
                        <label>Precio</label>
                        <input type="text" class="form-control" wire:model="detailPrice" id="detailPrice"
                            wire:blur="totalLine">
                    </div>
                    <div class="form-group col-md-2">
                        <label>Total</label>
                        <input type="text" class="form-control" wire:model="detailTotal" id="detailTotal">
                    </div>
                    <div class="form-group col-md-2" wire:ignore>
                        <label>Bodega</label>
                        <select class="form-control selectpicker" wire:model="detailPlace" id="detailPlace">
                            <option value="">Seleccione...</option>
                            @foreach ($places as $p)
                                <option value="{{ $p->id }}" data-subtext="{{ $p->code }}">
                                    {{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-1">
                        <label for=""></label>
                        <button class="btn btn-primary mt-2" wire:click="addLine">Agregar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <table class="table table-sm table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Destino</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($detailProducts)
                            @foreach ($detailProducts as $item)
                                <tr>
                                    <td>{{ $item['productName'] }}</td>
                                    <td>{{ $item['quantity'] }}</td>
                                    <td>{{ $item['price'] }}</td>
                                    <td>{{ $item['placeName'] }}</td>
                                    <td>{{ $item['total'] }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    @livewire('form-provider-component')

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

            Livewire.on("addLineFocus", function() {
                document.querySelector("#detailProduct").value = "";
                document.querySelector("#detailProduct").focus();
            });
        </script>
    @endpush
</div>
