@extends('layouts.asistencia')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Agregar estudiantes a Nómina</h1>
                <ul>
                    <li class="text-danger">
                        {{ count($lista) }} estudiantes en Teams que no se encuentran en nómina
                    </li>
                    <li class="text-info">
                        Ultimo registro de Teams actualizado el {{ $lastInserted }}, para actualizar registro haca clic
                        <a href="{{ route('estudiante.create') }}">AQUÍ</a>
                    </li>
                </ul>
                <table class="table table-sm table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Nombre Estudiante</th>
                            <th>Curso</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lista as $student)
                            <tr>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->departament }}</td>
                                <td>
                                    <button class="btn btn-primary" onclick="agregar({{ $student }})">
                                        Agregar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="modalAgregar">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar a Nómina</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="row" action="{{ route('nomina.store') }}" method="POST">
                        @csrf
                        <div class="form-group col-sm-12">
                            <label>Estudiante</label>
                            <input type="text" class="form-control" id="student" name="student" readonly>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Curso</label>
                            <input type="text" class="form-control" id="curso" name="curso" readonly>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Numero de Lista</label>
                            <input type="number" class="form-control" required id="number" name="number">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Primer Nombre</label>
                            <input type="text" class="form-control" required id="name1" name="name1" value="">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Segundo Nombre</label>
                            <input type="text" class="form-control" id="name2" name="name2" value="">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Primer Apellido</label>
                            <input type="text" class="form-control" required id="lastname1" name="lastname1" value="">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Segundo Apellido</label>
                            <input type="text" class="form-control" required id="lastname2" name="lastname2" value="">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>RUN (sin puntos)</label>
                            <input type="text" class="form-control" required id="run" name="run"
                                placeholder="Ej. 12345678-9">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Género</label>
                            <select class="form-control" required id="genre" name="genre">
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Fecha de Nacimiento</label>
                            <input type="date" class="form-control" required id="birthday" name="birthday">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Número de Matrícula</label>
                            <input type="number" class="form-control" required id="matricula" name="matricula">
                        </div>
                        <div class="col-sm-12 text-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function agregar(student) {
            $("#modalAgregar").modal("show");
            document.querySelector("#student").value = student.name;
            document.querySelector("#curso").value = student.departament;
            getNumeroLista(student.departament);
        }

        function getNumeroLista(curso) {
            $.get("/getLastNumberByCurso/" + curso, function(data) {
                document.querySelector("#number").value = data;
            });
        }
    </script>

@endsection
