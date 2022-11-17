<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createDataModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="createDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDataModalLabel">Crear nuevo Empleado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
           <div class="modal-body">
				<form>
                    <div class="form-group">
                        <label for="area_id">Seleccione un Área</label>
                        <select wire:model="area_id" id="area_id" class="form-control select2" >
                            <option>-Seleccione una opción-</option>
                            @foreach ($areas as $item)
                            <option value="{{ $item->id }}">{{ $item->nombreArea }}</option>
                            @endforeach
                        </select>
                        @error('area_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <h4 class="modal-title">Datos Usuario:</h4>
                    <div class="form-group">
                        <label for="nombres">Nombres</label>
                        <input wire:model="nombres" type="text" class="form-control" id="nombres" placeholder="Nombres">@error('nombres') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="apellidos">Apellidos</label>
                        <input wire:model="apellidos" type="text" class="form-control" id="apellidos" placeholder="Apellidos">@error('apellidos') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="tipo_doc">Tipo documento</label>
                        <select wire:model="tipo_doc" id="tipo_doc" class="form-control">
                            <option>-Seleccione una opción-</option>
                            <option value="1">Cédula de Ciudadanía</option>
                            <option value="2">Cédula de Extranjería</option>
                            <option value="3">Pasaporte</option>
                            <option value="4">NUIP</option>
                        </select>
                        @error('tipo_doc') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="cedula"># Documento</label>
                        <input wire:model="cedula" type="text" class="form-control" id="cedula" placeholder="Cedula">@error('cedula') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input wire:model="email" type="text" class="form-control" id="email" placeholder="Email">@error('email') <span class="error text-danger">{{ $message }}</span> @enderror
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
