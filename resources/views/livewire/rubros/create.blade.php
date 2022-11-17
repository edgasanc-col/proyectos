<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createDataModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="createDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDataModalLabel">Crear nuevo Rubro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
           <div class="modal-body">
				<form>
                    <div class="form-group">
                        <label for="nombreRubro">Nombre Rubro</label>
                        <input wire:model="nombreRubro" type="text" class="form-control" id="nombreRubro" placeholder="Nombrerubro">@error('nombreRubro') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="codigoContable">Código Contable</label>
                        <input wire:model="codigoContable" type="text" class="form-control" id="codigoContable" placeholder="Codigocontable">@error('codigoContable') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="variasFuentes">Varias Fuentes</label>
                        <select wire:model="variasFuentes" id="variasFuentes" class="form-control">
                            <option value="">-Seleccione una opción-</option>
                            <option value="0">No</option>
                            <option value="1">Si</option>
                        </select>
                        @error('variasFuentes') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Cerrar</button>
                <button type="button" wire:click.prevent="store()" class="btn btn-primary close-modal">Guardar</button>
            </div>
        </div>
    </div>
</div>
