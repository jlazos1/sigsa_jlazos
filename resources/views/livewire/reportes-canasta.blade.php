<div>
    <div class="row">
        <div class="form-group col">
            <label>Fecha</label>
            <input class="form-control" type="date" wire:model="fecha">
        </div>
        <div class="form-group col">
            <label>Nivel</label>
            <select class="form-control" wire:model="nivel">
                <option value="">Seleccione...</option>
                <option value="parvulario">Parvulario</option>
                <option value="basica">Básica</option>
                <option value="media">Media</option>
            </select>
        </div>
        <div class="form-group col mt-4">
            <button class="btn btn-primary" wire:click="buscar">
                <div class="spinner-border spinner-border-sm" wire:loading wire:target="buscar">
                    <span class="visually-hidden">Buscando...</span>
                </div>
                Buscar
            </button>
        </div>
    </div>

    @if ($errorBuscar)
    <div class="text-danger mt-2">
        {{$errorBuscar}}
    </div>
    @endif

    @if ($informe)
    <div class="row mt-3">
        <div class="col">
            <table class="table table-sm table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center" colspan="2">Beneficiciario</th>
                        <th class="text-center" colspan="2">Persona que retira</th>
                        <th class="text-center align-middle" rowspan="2">Curso</th>
                        <th class="text-center align-middle" rowspan="2">Observaciones</th>
                        <th class="text-center align-middle" rowspan="2">Fecha y Hora</th>
                    </tr>
                    <tr>
                        <th class="text-center">RUN</th>
                        <th class="text-center">Nombre</th>
                        <th class="text-center">RUN</th>
                        <th class="text-center">Nombre</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($informe as $linea)
                    <tr>
                        <td>{{ $linea->run }}</td>
                        <td>{{ $linea->student }}</td>
                        <td>{{ $linea->personRun }}</td>
                        <td>{{ $linea->personName }}</td>
                        <td>{{ $linea->course }}</td>
                        <td>{{ $linea->observations }}</td>
                        <td>{{ $linea->created_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>
