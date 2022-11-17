<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Actualizar Departamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span wire:click.prevent="cancel()" aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
					<input type="hidden" wire:model="selected_id">
                    <div class="form-group">
                        <label for="codigoDepartamento">Código Departamento</label>
                        <input wire:model="codigoDepartamento" type="text" class="form-control" id="codigoDepartamento" placeholder="Codigo departamento">@error('codigoDepartamento') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="nombreDepartamento"Nombre Departamento>Nombre Departamento</label>
                        <input wire:model="nombreDepartamento" type="text" class="form-control" id="nombreDepartamento" placeholder="Nombre departamento">@error('nombreDepartamento') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="pais_id">Seleccione un país</label>
                        <select wire:model="pais_id" id="pais_id" class="form-control">
                            <option>-Seleccione una opción-</option>
                            @foreach ($paises as $item)
                            <option value="{{ $item->id }}">{{ $item->nombrePais }}</option>
                            @endforeach
                        </select>
                        @error('pais_id') <span class="text-danger">{{ $message }}</span> @enderror
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
