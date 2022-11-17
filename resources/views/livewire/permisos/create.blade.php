<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createDataModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="createDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDataModalLabel">Crear nuevo Permiso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
           <div class="modal-body">
				<form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rol_id">Seleccione un Rol</label>
                                <select wire:model="rol_id" id="rol_id" class="form-control">
                                    <option>-Seleccione una opción-</option>
                                    @foreach ($roles as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombreRol }}</option>    
                                    @endforeach
                                </select>
                                @error('rol_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modulo_id">Seleccione un módulo</label>
                                <select wire:model="modulo_id" id="modulo_id" class="form-control">
                                    <option>-Seleccione una opción-</option>
                                    @foreach ($modulos as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombreModulo }}</option>    
                                    @endforeach
                                </select>
                                @error('modulo_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="crear">¿Puede Crear?</label>
                                <select wire:model="crear" id="crear" class="form-control">
                                    <option>-Seleccione una opción-</option>
                                    <option value="1">Si</option>
                                    <option value="0">No</option>
                                </select>
                                @error('crear') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ver">¿Puede Ver?</label>
                                <select wire:model="ver" id="ver" class="form-control">
                                    <option>-Seleccione una opción-</option>
                                    <option value="1">Si</option>
                                    <option value="0">No</option>
                                </select>
                                @error('ver') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="editar">¿Puede Editar?</label>
                            <select wire:model="editar" id="editar" class="form-control">
                                <option>-Seleccione una opción-</option>
                                <option value="1">Si</option>
                                <option value="0">No</option>
                            </select>
                            @error('editar') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="borrar">¿Puede Borrar?</label>
                            <select wire:model="borrar" id="borrar" class="form-control">
                                <option>-Seleccione una opción-</option>
                                <option value="1">Si</option>
                                <option value="0">No</option>
                            </select>
                            @error('borrar') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="importar">¿Puede Importar?</label>
                            <select wire:model="importar" id="importar" class="form-control">
                                <option>-Seleccione una opción-</option>
                                <option value="1">Si</option>
                                <option value="0">No</option>
                            </select>
                            @error('importar') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="exportar">¿Puede Exportar?</label>
                            <select wire:model="exportar" id="exportar" class="form-control">
                                <option>-Seleccione una opción-</option>
                                <option value="1">Si</option>
                                <option value="0">No</option>
                            </select>
                            @error('exportar') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
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
