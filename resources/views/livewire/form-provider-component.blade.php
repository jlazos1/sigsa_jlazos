<div wire:ignore>
    <div class="modal fade" id="modalAddProvider" tabindex="-1" aria-labelledby="modalAddProviderLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddProviderLabel">Agregar Proveedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">RUT</label>
                        <input type="text" class="form-control" wire:model="rut" required>
                    </div>
                    <div class="form-group">
                        <label for="">NOMBRE O RAZÓN SOCIAL</label>
                        <input type="text" class="form-control" wire:model="name" required>
                    </div>
                    <div class="form-group">
                        <label for="">DIRECCIÓN</label>
                        <input type="text" class="form-control" wire:model="address" required>
                    </div>
                    <div class="form-group">
                        <label for="">COMUNA</label>
                        <input type="text" class="form-control" wire:model="city" required>
                    </div>
                    <div class="form-group">
                        <label for="">CORREO-E</label>
                        <input type="email" class="form-control" wire:model="email" required>
                    </div>
                    <button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" data-dismiss="modal" wire:click="store">Agregar</button>
                </div>
            </div>
        </div>
    </div>



</div>
