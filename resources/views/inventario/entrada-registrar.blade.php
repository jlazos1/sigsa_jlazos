@extends('layouts.inventario')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Documento de Entrada</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                @livewire('entrada-registro-component')
            </div>
        </div>
    </div>
@endsection
