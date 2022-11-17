<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createDataModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="createDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDataModalLabel">Crear nuevo Departamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
           <div class="modal-body">
				<form>
                    <div class="form-group">
                        <label for="codigoDepartamento">Código Departamento</label>
                        <input wire:model="codigoDepartamento" type="text" class="form-control" id="codigoDepartamento" placeholder="Código departamento">@error('codigoDepartamento') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="nombreDepartamento">Nombre Departamento</label>
                        <input wire:model="nombreDepartamento" type="text" class="form-control" id="nombreDepartamento" placeholder="Nombre departamento">@error('nombreDepartamento') <span class="error text-danger">{{ $message }}</span> @enderror
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
            
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Cerrar</button>
                <button type="button" wire:click.prevent="store()" class="btn btn-primary close-modal">Guardar</button>
            </div>
        </div>
    </div>
</div>
