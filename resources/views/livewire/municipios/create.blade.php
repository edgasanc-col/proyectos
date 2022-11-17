<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createDataModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="createDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDataModalLabel">Crear nuevo Municipio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
           <div class="modal-body">
				<form>
                    <div class="form-group">
                        <label for="codigoMunicipio">Código Municipio</label>
                        <input wire:model="codigoMunicipio" type="text" class="form-control" id="codigoMunicipio" placeholder="Código municipio">@error('codigoMunicipio') <span class="text-danger">{{ $message }}</span> @enderror
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

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Cerrar</button>
                <button type="button" wire:click.prevent="store()" class="btn btn-primary close-modal">Guardar</button>
            </div>
        </div>
    </div>
</div>
