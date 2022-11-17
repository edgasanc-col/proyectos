<!-- Modal -->
<div wire:ignore.self class="modal fade" id="agregarModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="agregarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarModalLabel">Añadir Responsable al Resultado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" wire:model="selected_id">
                    <div class="add-input">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="empleado_id.0">Seleccione un empleado</label>
                                    <select wire:model="empleado_id.0" id="empleado_id" class="form-control select2" >
                                        <option>-Seleccione una opción-</option>
                                        @foreach ($empleados as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombres }} {{$item->apellidos}} - {{$item->nombreArea}} - {{$item->nombreOrganizacion}}</option>
                                        @endforeach
                                    </select>
                                    @error('empleado_id.0') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button class="btn text-white btn-info btn-block mt-4"  wire:click.prevent="add({{$i}})">Añadir Responsable</button>
                            </div>
                        </div>
                    </div>
                    @foreach($inputs as $key =>$value)
                        <div class=" add_input">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <select wire:model="empleado_id.{{ $value }}" id="empleado_id.{{ $value }}" class="form-control select2" >
                                            <option>-Seleccione una opción-</option>
                                            @foreach ($empleados as $item)
                                            <option value="{{ $item->id }}">{{ $item->nombres }} {{$item->apellidos}} - {{$item->nombreArea}} - {{$item->nombreOrganizacion}}</option>
                                            @endforeach
                                        </select>
                                        @error('empleado_id.') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-danger btn-block" wire:click.prevent="remove({{$key}})">Eliminar</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" wire:click.prevent="guardaragregar()" class="btn btn-primary" data-dismiss="modal">Añadir</button>
            </div>
        </div>
    </div>
</div>
