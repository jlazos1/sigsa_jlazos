<div>
    <div class="row">
        <div class="col-md-7">
            <div class="form-group">
                <label>Curso</label>
                <input type="text" class="form-control" wire:model="inputCurso" list="cursos"
                    placeholder="Ejemplo :  MEDIA-2-B">
                <datalist id="cursos">
                    @foreach ($cursos as $c)
                    <option value="{{$c->departament}}">
                        {{$c->departament}}
                    </option>
                    @endforeach
                </datalist>
            </div>
            @if ($estudiantes)
            <div class="form-group">
                <label>Estudiante</label>
                <input type="text" class="form-control" wire:model="inputStudent" list="students" autocomplete="off"
                    placeholder="Comience a escribir para filtrar">
                <datalist id="students">
                    @foreach ($estudiantes as $item)
                    <option value="{{$item->name}}">{{$item->name}}</option>
                    @endforeach
                </datalist>
            </div>
            <button class="btn btn-success mt-2" wire:click="buscar">
                <div class="spinner-border spinner-border-sm" role="status" wire:loading wire:target="buscar">
                    <span class="visually-hidden"></span>
                </div>
                Buscar
            </button>
            <button class="btn btn-default mt-2" wire:click="limpiar">
                Limpiar
            </button>
            @endif

            @if ($student)
            @if ($beneficiary)
            <div class="row">
                <div class="col mt-3">

                    @php
                    $fecha = new DateTime($beneficiary);
                    $hoy = (new DateTime())->format("Y-m-d");

                    if ($fecha->format("Y-m-d") == $hoy ) {
                    echo "<div class='badge bg-info text-dark form-control'>
                        <h4>ASIGNADO PARA HOY ($beneficiary)</h4>
                    </div>";
                    }
                    if ($fecha->format("Y-m-d") > $hoy ) {
                    echo "<div class='badge bg-warning text-dark form-control'>
                        <h4>ASIGNADO PARA EL $beneficiary</h4>
                    </div>";
                    }

                    if ($fecha->format("Y") == 1900) {
                    echo "<div class='badge bg-dark form-control'>
                        <h4>EN LISTA DE ESPERA</h4>
                    </div>";
                    } elseif ($hoy > $fecha->format("Y-m-d")) {
                    echo "<div class='badge bg-danger text-dark form-control'>
                        <h4>NO TIENE CANASTA ASIGNADA</h4>
                    </div>";
                    }

                    @endphp

                </div>
            </div>
            @else
            <div class="row">
                <div class="col mt-3">
                    <div class="badge bg-danger">
                        <h3>No se encuentra en nómina ni en lista de espera</h3>
                    </div>
                </div>
            </div>
            @endif
            @endif

            @if ($ultimoEntregado)
            <div class="row">
                <div class="col">
                    <div class="badge bg-warning text-dark form-control">
                        <h6>
                            ULTIMA ENTREGA :
                            {{
                    (new DateTime($ultimoEntregado))->format("d-m-Y")
                    ." a las ".
                    (new DateTime($ultimoEntregado))->format("H:i:s")
                    }}
                        </h6>
                    </div>
                </div>
            </div>
            @endif

            <div class="row mt-3">
                <div class="col">
                    @if ($student)
                    <h3>Historial de entregas</h3>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Persona que retiró</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                        @if (count($baskets) > 0)
                        @foreach ($baskets as $basket)
                        @php
                        $fecha = new DateTime($basket->created_at);
                        @endphp
                        <tbody>
                            <tr>
                                <td class="text-center">
                                    {!! $fecha->format("d-m-Y")."<br>".$fecha->format("H:i") !!}
                                </td>
                                <td>{!! "<small>".$basket->personRun."</small><br>".$basket->personName !!}</td>
                                <td>{{$basket->observations}}</td>
                            </tr>
                        </tbody>
                        @endforeach
                        @else
                        <tr>
                            <td>No se encontraron registros</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
            @endif
        </div>
        <div class="col-md-5">
            @if ($student)
            <h3>Beneficiario</h3>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>RUN</th>
                        <td>{{$student->run}}</td>
                    </tr>
                    <tr>
                        <th>Nombres</th>
                        <td>{{$student->name1 ." ".$student->name2}}</td>
                    </tr>
                    <tr>
                        <th>Apellidos</th>
                        <td>{{$student->lastname1 ." ".$student->lastname2}}</td>
                    </tr>
                    <tr>
                        <th>Curso</th>
                        <td>{{$student->curso}}</td>
                    </tr>
                    <tr>
                        <th>F. Nacimiento</th>
                        <td>{{$student->birthday}}</td>
                    </tr>
                    {{-- <tr>
                        <th>Teléfono</th>
                        <td>{{$student->phone}}</td>
                    </tr> --}}
                </thead>
            </table>
            <div class="row mt-3">
                <div class="col">
                    <h3>Datos de la persona que retira el beneficio</h3>
                    <div class="form-group">
                        <label>RUN</label>
                        <input class="form-control" type="text" wire:model="personRun">
                    </div>
                    <div class="form-group">
                        <label>Nombre completo</label>
                        <input class="form-control" type="text" wire:model="personName">
                    </div>
                    <div class="form-group">
                        <label>Observaciones</label>
                        <input class="form-control" type="text" wire:model="observations">
                    </div>
                    @if ($errorEntrega)
                    <div class="alert alert-danger mt-2">
                        {{$errorEntrega}}
                    </div>
                    @endif
                    <div class="form-group text-center mt-3 mb-3">
                        <button class="btn {{$colorButton}} btn-lg" wire:click="entregarCanasta">
                            <div class="spinner-border spinner-border-sm" role="status" wire:loading
                                wire:target="entregarCanasta">
                                <span class="visually-hidden"></span>
                            </div>
                            {{$textButton}}
                        </button>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
