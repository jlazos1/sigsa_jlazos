@extends('layouts.prestamo')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2>Imprima comprobante</h2>
                <h4 class="mt-4">Instrucciones : </h4>
                <p>Este es el documento con el que el prestario comprueba que ha devuelto el producto en préstamo</p>
                <ol class="text-left">
                    <li>Imprima el comprobante</li>
                    <li>El funcionario que recibe el producto debe firmarlo o timbrarlo</li>
                    <li>Entregar el comprobante al prestatario</li>
                </ol>
                <embed src="{{ $archivo }}" type="application/pdf" width="100%" height="400px" />
                <a class="btn btn-success mt-3 mb-3" href="{{ route('prestamo.index') }}">Finalizar</a>
            </div>

        </div>
    </div>

@endsection
