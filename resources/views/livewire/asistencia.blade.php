<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h1>Ingreso Manual de Asistencia</h1>
            <div class="alert alert-info">
                <b>IMPORTANTE : </b>
                <ul>
                    <li>
                        Ponga especial atención y modifique la asistencia que corresponde al bloque horario que le
                        corresponde.
                    </li>
                    <li>
                        Simbología :
                        <span class="text-danger"><b>A</b> (Ausente)</span>,
                        <span class="text-warning"><b>F</b> (Presencia Física) </span>y
                        <span class="text-success"><b>R</b> (Presente Remoto)</span>.
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="row">
                <div class="col-sm-12">
                    <label>Fecha</label>
                    <input class="form-control" type="date" wire:model="fecha"
                        value="{{ (new DateTime())->format('Y-m-d') }}" required>
                </div>
                <div class="col-sm-12" wire:ignore>
                    <label>Curso</label>
                    <select class="form-control selectpicker" data-live-search="true" wire:model="curso" required>
                        <option value="">Seleccione...</option>
                        @foreach ($cursos as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-12 mt-2">
                    <button class="btn btn-success mb-3 form-control" wire:click="buscarAsistencia">Buscar</button>
                </div>
            </div>

            @if ($error)
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    </div>
                </div>
            @endif

            @if (count($temporal) > 0)
                <div class="row">
                    <div class="col-sm-12 mt-2">
                        <button class="btn btn-primary mb-3 form-control" wire:click="updateRecords">
                            Guardar cambios
                        </button>
                    </div>
                </div>
            @endif

            <div class="row" wire:loading wire:target="buscarAsistencia">
                <div class="col">
                    <div class="d-flex align-items-center">
                        <div class="spinner-border text-success ms-auto "></div>
                        &nbsp;&nbsp;
                        <strong class="text-success">Obteniendo registros...</strong>
                    </div>
                </div>
            </div>

            <div class="row" wire:loading wire:target="updateRecords">
                <div class="col">
                    <div class="d-flex align-items-center">
                        <div class="spinner-border text-primary ms-auto"></div>
                        &nbsp;&nbsp;
                        <strong class="text-primary">Guardando cambios...</strong>
                    </div>
                </div>
            </div>

        </div>

        @if ($informe != null)
            <div class="col-md-9">
                <div class="row">
                    <div class="col">
                        <table class="table table-sm table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th colspan="7" class="text-center">
                                        Fecha : {{ (new DateTime($fecha))->format('d-m-Y') }}
                                    </th>
                                </tr>
                                <tr>
                                    <th class="align-middle">N°</th>
                                    <th class="align-middle">Estudiante</th>
                                    <th class="text-center">
                                        <button type="button" class="btn btn-dark"
                                            wire:click="$emit('modal', {{ json_encode($ausentes['bloque1']) }})">
                                            B1
                                        </button>
                                    </th>
                                    <th class="text-center">
                                        <button type="button" class="btn btn-dark"
                                            wire:click="$emit('modal', {{ json_encode($ausentes['bloque2']) }})">
                                            B2
                                        </button>
                                    </th>
                                    <th class="text-center">
                                        <button type="button" class="btn btn-dark"
                                            wire:click="$emit('modal', {{ json_encode($ausentes['bloque3']) }})">
                                            B3
                                        </button>
                                    </th>
                                    <th class="text-center">
                                        <button type="button" class="btn btn-dark"
                                            wire:click="$emit('modal', {{ json_encode($ausentes['bloque4']) }})">
                                            B4
                                        </button>
                                    </th>
                                    <th class="text-center">
                                        <button type="button" class="btn btn-dark"
                                            wire:click="$emit('modal', {{ json_encode($ausentes['bloque5']) }})">
                                            B5
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($informe as $key => $item)
                                    <tr>
                                        <td class="align-middle">{{ $item['numero'] }}</td>
                                        <td class="align-middle">
                                            {{ $item['estudiante'] }}
                                            <span class="spinner-border text-success spinner-border-sm float-right"
                                                wire:loading wire:target="changeState" role="status"
                                                aria-hidden="true"></span>
                                        </td>
                                        @foreach ($item['asistencia'] as $asist)
                                            <td class="text-center">
                                                @if ($asist['bloque1'] == 1)
                                                    <button class="btn btn-success"
                                                        wire:click="changeRecord({{ $key }},{{ json_encode($item) }}, 1)">R</button>
                                                @elseif ($asist['bloque1'] == 2)
                                                    <button class="btn btn-warning"
                                                        wire:click="changeRecord({{ $key }},{{ json_encode($item) }}, 1)">F</button>
                                                @else
                                                    <button class="btn btn-danger"
                                                        wire:click="changeRecord({{ $key }},{{ json_encode($item) }}, 1)">A</button>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($asist['bloque2'] == 1)
                                                    <button class="btn btn-success"
                                                        wire:click="changeRecord({{ $key }},{{ json_encode($item) }}, 2)">R</button>
                                                @elseif ($asist['bloque2'] == 2)
                                                    <button class="btn btn-warning"
                                                        wire:click="changeRecord({{ $key }},{{ json_encode($item) }}, 2)">F</button>
                                                @else
                                                    <button class="btn btn-danger"
                                                        wire:click="changeRecord({{ $key }},{{ json_encode($item) }}, 2)">A</button>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($asist['bloque3'] == 1)
                                                    <button class="btn btn-success"
                                                        wire:click="changeRecord({{ $key }},{{ json_encode($item) }}, 3)">R</button>
                                                @elseif ($asist['bloque3'] == 2)
                                                    <button class="btn btn-warning"
                                                        wire:click="changeRecord({{ $key }},{{ json_encode($item) }}, 3)">F</button>
                                                @else
                                                    <button class="btn btn-danger"
                                                        wire:click="changeRecord({{ $key }},{{ json_encode($item) }}, 3)">A</button>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($asist['bloque4'] == 1)
                                                    <button class="btn btn-success"
                                                        wire:click="changeRecord({{ $key }},{{ json_encode($item) }}, 4)">R</button>
                                                @elseif ($asist['bloque4'] == 2)
                                                    <button class="btn btn-warning"
                                                        wire:click="changeRecord({{ $key }},{{ json_encode($item) }}, 4)">F</button>
                                                @else
                                                    <button class="btn btn-danger"
                                                        wire:click="changeRecord({{ $key }},{{ json_encode($item) }}, 4)">A</button>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($asist['bloque5'] == 1)
                                                    <button class="btn btn-success"
                                                        wire:click="changeRecord({{ $key }},{{ json_encode($item) }}, 5)">R</button>
                                                @elseif ($asist['bloque5'] == 2)
                                                    <button class="btn btn-warning"
                                                        wire:click="changeRecord({{ $key }},{{ json_encode($item) }}, 5)">F</button>
                                                @else
                                                    <button class="btn btn-danger"
                                                        wire:click="changeRecord({{ $key }},{{ json_encode($item) }}, 5)">A</button>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Estudiantes Inasistentes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalBody">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal" wire:click="$emit('copyToRam')">
                        <i class="material-icons">content_copy</i>
                        Copiar
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if ($informe != null)
        <div class="modal fade" id="finishUpdate" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Correctamente actualizados!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <h3>Seleccione el bloque para ver inasistentes : </h3>
                        <button type="button" class="btn btn-dark" data-dismiss="modal"
                            wire:click="$emit('modal', {{ json_encode($ausentes['bloque1']) }})">
                            B1
                        </button>
                        <button type="button" class="btn btn-dark" data-dismiss="modal"
                            wire:click="$emit('modal', {{ json_encode($ausentes['bloque2']) }})">
                            B2
                        </button>
                        <button type="button" class="btn btn-dark" data-dismiss="modal"
                            wire:click="$emit('modal', {{ json_encode($ausentes['bloque3']) }})">
                            B3
                        </button>
                        <button type="button" class="btn btn-dark" data-dismiss="modal"
                            wire:click="$emit('modal', {{ json_encode($ausentes['bloque4']) }})">
                            B4
                        </button>
                        <button type="button" class="btn btn-dark" data-dismiss="modal"
                            wire:click="$emit('modal', {{ json_encode($ausentes['bloque5']) }})">
                            B5
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @push('script')
        <script>
            Livewire.on("modal", bloque => {
                $("#modal").modal("show");
                let lista = "";
                bloque.forEach((item, key) => {
                    lista += item + (key == bloque.length - 1 ? "" : "-")
                });
                console.log("esto " + bloque)
                document.querySelector("#modalBody").innerHTML = lista;
            });
        </script>
        <script>
            Livewire.on("finishUpdate", bloque => {
                $("#finishUpdate").modal("show");
            });
        </script>
        <script>
            Livewire.on("copyToRam", async function() {
                let ausentes = document.querySelector("#modalBody").innerText;
                await navigator.clipboard.writeText(ausentes)
                window.open('https://cuentas.napsis.cl', '_blank');
            });
        </script>
    @endpush

</div>
