<div class="row">
    @if (!$acceso)
    <div class="col-sm-4 offset-sm-4 text-center">
        <h3>Acceso</h3>
        <div class="form-group">
            <label>Escribe tu correo</label>
            <input class="form-control" type="email" wire:model="correo">
        </div>
        <div class="form-group">
            <label>Escribe tu PIN</label>
            <input class="form-control" type="number" wire:model="pin">
        </div>
        <div class="form-group mt-3">
            <button class="btn btn-primary form-control" wire:click="ingresar">
                Ingresa
            </button>
        </div>
        @if ($error)
        <div class="row">
            <div class="col">
                <div class="alert alert-danger mt-3">
                    {{$error}}
                </div>
            </div>
        </div>
        @endif
    </div>
    @else
    <div class="col text-center">
        <h3>Selecciona a tu mejor compañero(a)</h3>
        <select wire:model="candidate" class="form-control">
            <option value="">Seleccione...</option>
            @foreach ($curso as $item)
            <option value="{{$item->email}}">{{$item->name}}</option>
            @endforeach
        </select>
        <button class="btn btn-lg btn-success mt-3" wire:click="elegir">Enviar votación</button>
    </div>
    @if ($success)
    <div class="row">
        <div class="col">
            <div class="alert alert-success mt-3">
                {{$success}}
            </div>
        </div>
    </div>
    @endif

    @if ($error)
    <div class="row">
        <div class="col">
            <div class="alert alert-danger mt-3">
                {{$error}}
            </div>
        </div>
    </div>
    @endif
    @endif
</div>
