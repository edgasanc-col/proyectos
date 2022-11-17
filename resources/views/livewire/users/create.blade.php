<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createDataModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="createDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDataModalLabel">Crear nuevo usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
           <div class="modal-body">
				<form>
                    <div class="row">
                        <div class="col-md-6">
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
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cedula"># Documento</label>
                                <input wire:model="cedula" type="text" class="form-control" id="cedula" placeholder="Cedula">
                                @error('cedula') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombres">Nombres</label>
                                <input wire:model="nombres" type="text" class="form-control" id="nombres" placeholder="Nombres">
                                @error('nombres') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="apellidos">Apellidos</label>
                                <input wire:model="apellidos" type="text" class="form-control" id="apellidos" placeholder="Apellidos">
                                @error('apellidos') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input wire:model="email" type="text" class="form-control" id="email" placeholder="Email">
                                @error('email') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input wire:model="password" type="password" class="form-control" id="password" placeholder="Password">
                                @error('password') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="rol_id">Rol</label>
                                <select wire:model="rol_id" id="rol_id" class="form-control">
                                    <option>-Seleccione una opción-</option>
                                    @foreach ($roles as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombreRol }}</option>
                                    @endforeach
                                </select>
                                @error('rol_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
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
