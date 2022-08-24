@extends('layouts.prestamo')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col text-center mt-3 mb-5">
                @if ($option == 'confirmar')
                    <h1>Confirmar Préstamo</h1>
                    <p>Revise los datos y, si está correcto, confirme.</p>
                    <form action="{{ route('confirmar.funcionario') }}" method="post" class="mb-3"
                        enctype="multipart/form-data">
                        @csrf
                        @method("POST")
                        <input type="hidden" name="loan_id" value="{{ $loan->id }}">
                        <div class="mt-5">
                            <button class="btn btn-success">Confirmar</button>
                            <a href="{{ url()->previous() }}" class="btn btn-flat">Cancelar</a>
                        </div>
                    </form>
                    <embed src="{{ $archivo }}" type="application/pdf" width="100%" height="600px" />
                @endif
                @if ($option == 'comprobante')
                    <h1>Cargar Comprobante</h1>
                    <p>Revise los datos y, si está correcto, cargue el comprobante firmado y confirme operación.</p>
                    <form action="{{ route('confirmar.funcionario') }}" method="post" class="mb-4"
                        enctype="multipart/form-data">
                        @csrf
                        @method("POST")
                        <input type="hidden" name="loan_id" value="{{ $loan->id }}">
                        <div id="inputFile" class="input-group text-left">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon01">Comprobante</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGroupFile01" name="voucher"
                                    aria-describedby="inputGroupFileAddon01" required>
                                <label class="custom-file-label" for="inputGroupFile01">Cargar comprobante...</label>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-primary">Confirmar operación</button>
                            <a href="{{ url()->previous() }}" class="btn btn-flat">Cancelar</a>
                        </div>
                    </form>
                    <embed src="{{ $archivo }}" type="application/pdf" width="100%" height="600px" />
                @endif
            </div>
        </div>
    </div>
@endsection
