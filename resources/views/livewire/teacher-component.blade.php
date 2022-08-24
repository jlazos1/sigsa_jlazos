<div>
    <div class="row">
        <div class="col">
            <label>Desde</label>
            <input class="form-control" type="date" wire:model="desde">
        </div>
        <div class="col">
            <label>Hasta</label>
            <input class="form-control" type="date" wire:model="hasta">
        </div>
        <div class="col">
            <label>Horario</label><br>
            <select class="form-control" wire:model="horario">
                <option value="">Seleccione...</option>
                <option value="n1">1ero a 5to básico</option>
                <option value="n2">6to a 4to medio</option>
            </select>
        </div>
        <div class="col">
            <label>Profesor(a)</label>
            <select class="form-control" wire:model="profesor">
                <option value="">Seleccione...</option>
                @foreach ($profesores as $p)
                <option value="{{$p->name}}">{{$p->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <label> </label>
            <button class="btn btn-success mb-3 form-control" wire:click="buscarAsistencia">Buscar</button>
        </div>
    </div>
    <div class="row">
        <div class="col">
            @if ($error)
            <div class="alert alert-danger">
                {{$error}}
            </div>
            @endif
        </div>
    </div>
    @if ($informe)
    <div class="row">
        <div class="col">
            <table class="table table-sm">
                <thead class="table-primary">
                    <tr>
                        <th>Fecha</th>
                        <th class="text-center">B1</th>
                        <th class="text-center">B2</th>
                        <th class="text-center">B3</th>
                        <th class="text-center">B4</th>
                        <th class="text-center">B5</th>
                        <th class="text-center">HD</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($informe as $item)
                    @php
                    $suma = ($item["bloque1"]+$item["bloque2"]+$item["bloque3"]+$item["bloque4"]+$item["bloque5"])*2;
                    @endphp
                    <tr>
                        <td>{{ (new DateTime($item["dia"]))->format("d-m-Y")}}</td>
                        <td class="text-center">
                            @if($item["bloque1"])
                            <span class="material-icons text-success">check</span>
                            @else
                            <span class="material-icons text-danger">close</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($item["bloque2"])
                            <span class="material-icons text-success">check</span>
                            @else
                            <span class="material-icons text-danger">close</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($item["bloque3"])
                            <span class="material-icons text-success">check</span>
                            @else
                            <span class="material-icons text-danger">close</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($item["bloque4"])
                            <span class="material-icons text-success">check</span>
                            @else
                            <span class="material-icons text-danger">close</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($item["bloque5"])
                            <span class="material-icons text-success">check</span>
                            @else
                            <span class="material-icons text-danger">close</span>
                            @endif
                        </td>
                        <td class="text-center">
                            {{$suma}} hrs.
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
