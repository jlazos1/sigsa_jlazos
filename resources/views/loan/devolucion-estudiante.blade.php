@extends('layouts.prestamo')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2 text-center">
                <img src="{{ asset('icons/005-estudiantes.png') }}" class="mt-3" width="100px">
                <h1>Devolución de préstamo</h1>
                <div class="form-group">
                    <label>Seleccione Estudiante</label>
                    <select name="student_id" id="student_id" class="selectpicker form-control" data-live-search="true"
                        required>
                        <option value="">Seleccione..</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}"
                                data-subtext="{{ $student->enrollments->last()->course->name }}"
                                {{ $student_id == $student->id ? 'selected' : '' }}>
                                {{ $student->name }}
                            </option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary mt-3" onclick="findLoans()">Buscar préstamos</button>
                </div>
            </div>
        </div>
        @if (isset($loans))
            <div class="row">
                <div class="col">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Responsable</th>
                                <th>Equipo</th>
                                <th>Desde</th>
                                <th>Hasta</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            @foreach ($loans as $loan)
                                <tr>
                                    <td>{{ $loan->id }}</td>
                                    <td>
                                        {{ $loan->proxy->name1 .' ' .$loan->proxy->name2 .' ' .$loan->proxy->lastname1 .' ' .$loan->proxy->lastname2 }}
                                        <small>({{ $loan->proxy->getRelationship($loan->student_id) }})</small>
                                    </td>
                                    <td>{{ $loan->details[0]->product_name }}</td>
                                    <td>{{ $loan->delivery }}</td>
                                    <td>{{ $loan->return }}</td>
                                    <td>
                                        @if ($loan->returned)
                                            <span class="badge badge-info">DEVUELTO</span>
                                        @else
                                            @if ($loan->confirmed)
                                                <span class="badge badge-success">PRESTAMO ACTIVO</span>
                                            @else
                                                <span class="badge badge-warning">FALTA CONFIRMACION</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if (!$loan->returned)
                                            <button class="btn btn-sm btn-danger form-control mb-1"
                                                title="Devolver préstamo" onclick="modalDevolver({{ $loan }})">
                                                {{-- <img class="img-thumbnail" src="{{ asset('icons/001-entregar.png') }}"
                                                    width="30px"> --}}
                                                DEVOLVER
                                            </button>
                                        @endif
                                        <a class="btn btn-sm btn-info form-control"
                                            href="{{ route('prestamo.ver', ['id' => $loan->id]) }}" title="Ver préstamo">
                                            {{-- <img class="img-thumbnail" src="{{ asset('icons/007-encuesta.png') }}"
                                                width="30px"> --}}
                                            VER
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    <div class="modal fade" id="devolucionModal" tabindex="-1" aria-labelledby="devolucionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="devolucionModalLabel">Devolución de préstamo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('prestamo.devolucion.confirma') }}" method="post">
                        @csrf
                        @method("POST")
                        <input type="hidden" name="loan_id" id="modalLoanId">
                        <div class="form-group">
                            <label for=""><b>Observaciones previas</b></label>
                            <p id="observations"></p>
                        </div>

                        <div class="form-group">
                            <label for=""><b>Observaciones al devolver</b></label>
                            <textarea class="form-control" name="observations" rows="3"></textarea>
                        </div>

                        <button type="button" class="btn btn-flat float-right" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success float-right">CONFIRMAR</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function findLoans() {
            let student_id = document.querySelector("#student_id").value;
            location.href = "/prestamo/devolucion/estudiante/" + student_id;
        }

        function modalDevolver(loan) {
            document.querySelector("#modalLoanId").value = loan.id;
            document.querySelector("#devolucionModalLabel").innerHTML = "Devolución de Préstamo #" + loan.id;
            document.querySelector("#observations").innerHTML = loan.observations ? loan.observations :
                "Sin observaciones previas";
            $("#devolucionModal").modal("show");
        }
    </script>

@endsection
