<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Actualizar Municipio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span wire:click.prevent="cancel()" aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
					<input type="hidden" wire:model="selected_id">
                    <div class="form-group">
                        <label for="codigoMunicipio">Código Municipio</label>
                        <input wire:model="codigoMunicipio" type="text" class="form-control" id="codigoMunicipio" placeholder="Codigo municipio">@error('codigoMunicipio') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                
                    <div class="form-group">
                        <label for="nombreMunicipio">Nombre Municipio</label>
                        <input wire:model="nombreMunicipio" type="text" class="form-control" id="nombreMunicipio" placeholder="Nombre municipio">@error('nombreMunicipio') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="departamento_id">Seleccione un departamento</label>
                        <select wire:model="departamento_id" id="departamento_id" class="form-control select2" >
                            <option>-Seleccione una opción-</option>
                            @foreach ($departamentos as $item)
                            <option value="{{ $item->id }}">{{ $item->nombreDepartamento }}</option>
                            @endforeach
                        </select>
                        @error('departamento_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select wire:model="estado" id="estado" class="form-control">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                        @error('estado') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" wire:click.prevent="update()" class="btn btn-primary" data-dismiss="modal">Guardar</button>
            </div>
       </div>
    </div>
</div>
