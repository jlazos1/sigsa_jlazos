@extends('layouts.inventario')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h1>Registrar Préstamo / Comodato</h1>
            <div class="alert alert-success">
                <b>Importante :</b>
                Ingrese los datos del destinatario y seleccione el/los mobiliarios en préstamo o comodato.
                En el listado de mobiliario se mostrarán solo los productos que están en BODEGA-CENTRAL.
            </div>
            @livewire('prestamo-registro-component')
        </div>
    </div>
</div>
@endsection
