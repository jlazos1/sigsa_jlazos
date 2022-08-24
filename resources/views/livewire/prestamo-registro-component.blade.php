<div>
    <form wire:submit.prevent="irPaso2">
        <div class="card" {{$section_paso1}}>
            <div class="card-header bg-success text-white">PASO 1 : INGRESE LOS DATOS DEL(LA) DESTINATARIO(A)</div>
            <div class="card-body">
                <div class="form-group">
                    <label>RUN</label>
                    <input type="text" placeholder="Ej. 123456789-0"
                        class="form-control {{$valid_run}} @error('run'){{'is-invalid'}}@enderror" wire:model="run">
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label>Nombre</label>
                        <input type="text" class="form-control @error('nombre'){{'is-invalid'}}@enderror"
                            wire:model="nombre">
                    </div>
                    <div class="form-group col">
                        <label>Apellidos</label>
                        <input type="text" class="form-control @error('apellidos'){{'is-invalid'}}@enderror"
                            wire:model="apellidos">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label>Dirección</label>
                        <input type="text" class="form-control @error('direccion'){{'is-invalid'}}@enderror"
                            wire:model="direccion">
                    </div>
                    <div class="form-group col">
                        <label>Comuna</label>
                        <select class="form-control @error('comuna'){{'is-invalid'}}@enderror" wire:model="comuna">
                            <option value="">Seleccione...</option>
                            @foreach ($comunas as $c)
                            <option value="{{$c}}">{{$c}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label>Teléfono</label>
                        <input type="tel" placeholder="+56"
                            class="form-control @error('telefono'){{'is-invalid'}}@enderror" wire:model="telefono">
                    </div>
                    <div class="form-group col">
                        <label>Correo-E</label>
                        <input type="email" class="form-control @error('correo'){{'is-invalid'}}@enderror"
                            wire:model="correo">
                    </div>
                </div>
            </div>
            <div class="card-footer bg-success">
                <button class="btn btn-outline-light" style="display:inline-block;float:right;">
                    SIGUIENTE
                </button>
            </div>
        </div>
    </form>
    <div class="card" {{$section_paso2}}>
        <div class="card-header bg-success text-white">PASO 2 : Seleccione el/los mobiliario(s)</div>
        <div class="card-body">
            <div class="form-group">
                <label>1. Seleccione tipo de mobiliario</label>
                <select class="form-control" wire:model="producto_tipo" wire:change="selectType">
                    <option value="">Seleccione...</option>
                    @foreach ($producto_tipos as $t)
                    <option value="{{$t->id}}">{{$t->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>2. Seleccione Mobiliario</label>
                <select class="form-control" wire:model="producto">
                    <option value="">Seleccione...</option>
                    @foreach ($productos as $p)
                    <option value="{{$p->id}}">{{$p->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>3. Indique cantidad</label>
                <input type="number" class="form-control" wire:model="cantidad" value="1">
            </div>
        </div>
        <div class="card-footer bg-success">
            <button class="btn btn-outline-light" wire:click="irPaso1">ATRÁS</button>
            <button class="btn btn-outline-light" style="display: inline-block; float:right;" wire:click="irPaso3">
                SIGUIENTE
            </button>
        </div>
    </div>
    <div class="card" {{$section_paso3}}>
        <div class="card-header bg-success text-white">PASO 3 : Confirme los datos</div>
        <div class="card-body">

        </div>
        <div class="card-footer bg-success">
            <button class="btn btn-outline-light" wire:click="irPaso2">ATRÁS</button>
            <button class="btn btn-danger btn-outline-light" style="display: inline-block; float:right;"
                wire:click="irPasoFinal">
                CONFIRMAR
            </button>
        </div>
    </div>
</div>
