@extends('layouts.asistencia')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Asistencia por Curso</h1>
            </div>
        </div>

        <form class="row" action="" method="post">
            @csrf
            @method("GET")
            <div class="col">
                <label>Desde</label>
                <input class="form-control" type="date" name="desde" placeholder="Desde..." value="{{ $desde }}"
                    required>
            </div>
            <div class="col">
                <label>Hasta</label>
                <input class="form-control" type="date" name="hasta" value="{{ $hasta }}" required>
            </div>
            <div class="col">
                <label>Curso</label>
                <input list="cursos" class="form-control" type="text" name="curso" value="{{ $curso }}" required>
                <datalist id="cursos">
                    @foreach ($cursos as $c)
                        <option value="{{ $c->departament }}">{{ $c->departament }}</option>
                    @endforeach
                </datalist>
            </div>
            <div class="col">
                <label> </label>
                <button class="btn btn-success mb-3 form-control">Buscar</button>
            </div>
        </form>

        @if ($informe != null)
            <div class="row">
                <div class="col">
                    @php
                        $total_alumnos = count($informe);
                    @endphp
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr class="bg-primary text-white">
                                <th class="text-center">Día</th>
                                <th class="text-center">Presentes</th>
                                <th class="text-center">Ausentes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($totales as $total)
                                <tr>
                                    <td class="text-center bg-primary text-white">
                                        {{ (new DateTime($total['dia']))->format('d-m-Y') }}
                                    </td>
                                    <td class="text-center">{{ $total['total'] }}</td>
                                    <td class="text-center">{{ $total_alumnos - $total['total'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <table class="table table-sm table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th rowspan="2" class="align-middle">N°</th>
                                <th rowspan="2" class="align-middle">Estudiante</th>
                                @foreach ($informe[0]['asistencia'] as $item)
                                    <th colspan="5" class="text-center">{{ (new DateTime($item['dia']))->format('d-m') }}
                                    </th>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach ($informe[0]['asistencia'] as $item)
                            <tr>
                                <th class="align-middle">N°</th>
                                <th class="align-middle">Estudiante</th>
                                <th class="text-center">
                                    <button type="button" class="btn btn-dark"
                                        onclick="ausentes({{ json_encode($ausentes['bloque1']) }})">
                                        B1
                                    </button>
                                </th>
                                <th class="text-center">
                                    <button type="button" class="btn btn-dark"
                                        onclick="ausentes({{ json_encode($ausentes['bloque2']) }})">
                                        B2
                                    </button>
                                </th>
                                <th class="text-center">
                                    <button type="button" class="btn btn-dark"
                                        onclick="ausentes({{ json_encode($ausentes['bloque3']) }})">
                                        B3
                                    </button>
                                </th>
                                <th class="text-center">
                                    <button type="button" class="btn btn-dark"
                                        onclick="ausentes({{ json_encode($ausentes['bloque4']) }})">
                                        B4
                                    </button>
                                </th>
                                <th class="text-center">
                                    <button type="button" class="btn btn-dark"
                                        onclick="ausentes({{ json_encode($ausentes['bloque5']) }})">
                                        B5
                                    </button>
                                </th>
                            </tr>
        @endforeach
        </tr>
        </thead>
        <tbody>
            @foreach ($informe as $item)
                <tr>
                    <td>{{ $item['numero'] }}</td>
                    <td>{{ $item['estudiante'] }}</td>
                    @foreach ($item['asistencia'] as $asist)
                        <td class="text-center">
                            @if ($asist['bloque1'] == 1)
                                <h4 title="Remoto"><label class='badge badge-success'>R</label></h4>
                            @elseif ($asist["bloque1"] == 2)
                                <h4 title="Físico"><label class='badge badge-warning'>F</label></h4>
                            @else
                                <h4 title="Ausente"><label class='badge badge-danger'>A</label></h4>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($asist['bloque2'] == 1)
                                <h4 title="Remoto"><label class='badge badge-success'>R</label></h4>
                            @elseif ($asist["bloque2"] == 2)
                                <h4 title="Físico"><label class='badge badge-warning'>F</label></h4>
                            @else
                                <h4 title="Ausente"><label class='badge badge-danger'>A</label></h4>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($asist['bloque3'] == 1)
                                <h4 title="Remoto"><label class='badge badge-success'>R</label></h4>
                            @elseif ($asist["bloque3"] == 2)
                                <h4 title="Físico"><label class='badge badge-warning'>F</label></h4>
                            @else
                                <h4 title="Ausente"><label class='badge badge-danger'>A</label></h4>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($asist['bloque4'] == 1)
                                <h4 title="Remoto"><label class='badge badge-success'>R</label></h4>
                            @elseif ($asist["bloque4"] == 2)
                                <h4 title="Físico"><label class='badge badge-warning'>F</label></h4>
                            @else
                                <h4 title="Ausente"><label class='badge badge-danger'>A</label></h4>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($asist['bloque5'] == 1)
                                <h4 title="Remoto"><label class='badge badge-success'>R</label></h4>
                            @elseif ($asist["bloque5"] == 2)
                                <h4 title="Físico"><label class='badge badge-warning'>F</label></h4>
                            @else
                                <h4 title="Ausente"><label class='badge badge-danger'>A</label></h4>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
        </table>
    </div>
    </div>
    @endif
    </div>

    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Estudiantes Inasistentes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBody">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="copyToRam()">
                        <i class="material-icons">content_copy</i>
                        Copiar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function ausentes(bloque) {
            $("#modal").modal("show");
            let lista = "";
            bloque.forEach((item, key) => {
                lista += item + (key == bloque.length - 1 ? "" : "-")

            });
            console.log(bloque.length)
            document.querySelector("#modalBody").innerHTML = lista;
        }

        async function copyToRam() {
            let ausentes = document.querySelector("#modalBody").innerText;
            await navigator.clipboard.writeText(ausentes)
        }
    </script>

@endsection
