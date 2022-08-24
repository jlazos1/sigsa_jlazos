@extends('layouts.prestamo')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 text-center">
                <h2>Confirmación de Datos</h2>
                <h4 class="mt-4">Instrucciones : </h4>
                <ol class="text-left">
                    <li>Verifique que todos los datos estén correctos</li>
                    <li>Imprima el Comprobante de Préstamo</li>
                    <li>Con puño y letra el <b>prestatario</b> debe firmarlo</li>
                    <li>Adjunte documento firmado en <b>Comprobante (*)</b></li>
                    <li>Presione el botón <b>Confirmar</b></li>
                </ol>

                <span class="text-info">(*) Puede Confirmar sin necesidad de adjuntar el comprobante ahora.</span>

                <form id="formConfirm" action="{{ route('confirmar.estudiante') }}" method="post" class="mt-5"
                    enctype="multipart/form-data">
                    @csrf
                    @method("POST")
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="toggleFile" onclick="mostrarInput(this.checked)">
                        <label class="form-check-label" for="toggleFile">
                            Adjuntar comprobante firmado
                        </label>
                    </div>
                    <div id="inputFile" class="input-group mt-3 text-left" hidden>
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupFileAddon01">Comprobante</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFile01" name="voucher"
                                aria-describedby="inputGroupFileAddon01">
                            <label class="custom-file-label" for="inputGroupFile01">Seleccione comprobante...</label>
                        </div>
                    </div>
                    <div class="mt-5">
                        <button id="btnSubmit" type="submit" class="btn btn-success">
                            <span id="spinner" hidden class="spinner-border spinner-border-sm" role="status"
                                aria-hidden="true"></span>
                            Confirmar
                        </button>
                        <a href="{{ url()->previous() }}" class="btn btn-flat">Cancelar</a>
                    </div>
                </form>
            </div>
            <div class="col-md-8">
                <embed src="{{ $archivo }}" type="application/pdf" width="100%" height="600px" />
            </div>
        </div>

    </div>

    <script>
        function mostrarInput(valor) {
            let inputFile = document.querySelector("#inputFile");
            if (valor) {
                inputFile.hidden = false;
            } else {
                inputFile.hidden = true;
            }
        }

        document.querySelector("#formConfirm").addEventListener("submit", function() {
            document.querySelector("#btnSubmit").disabled = true;
            document.querySelector("#spinner").hidden = false;
        });
    </script>
@endsection
