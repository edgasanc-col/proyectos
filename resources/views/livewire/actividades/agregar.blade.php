<!-- Modal -->
<div wire:ignore.self class="modal fade" id="agregarModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="agregarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarModalLabel">Añadir Rubros a la actividad</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" wire:model="selected_id">
                    <div class="add-input">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="rubro_id.0">Seleccione un Rubro</label>
                                    <select wire:model="rubro_id.0" id="rubro_id.0" class="form-control select2" >
                                        <option>-Seleccione una opción-</option>
                                        @foreach ($rubros as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombreRubro }}</option>
                                        @endforeach
                                    </select>
                                    @error('rubro_id.0') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="valorUnitario.0">Valor Unitario</label>
                                    <input wire:model="valorUnitario.0" type="number" class="form-control" id="valorUnitario.0" placeholder="Valor unitario">
                                    @if($valorUnitario !=null)
                                        @if($valorUnitario[0] !=null)
                                        <span class="badge badge-primary">{{number_format($valorUnitario[0], 2, ',', '.')}}</span>
                                        @endif
                                    @endif
                                    @error('valorUnitario.0') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cantidad.0">Cantidad</label>
                                    <input wire:model="cantidad.0" type="number" class="form-control" id="cantidad.0" placeholder="Cantidad">
                                    @error('cantidad.0') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button class="btn text-white btn-info btn-block mt-4"  wire:click.prevent="add({{$i}})">Añadir Rubros</button>
                            </div>
                        </div>
                    </div>
                    @foreach($inputs as $key =>$value)
                        <div class=" add_input">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select wire:model="rubro_id.{{ $value }}" id="rubro_id.{{ $value }}" class="form-control select2" >
                                            <option>-Seleccione una opción-</option>
                                            @foreach ($rubros as $item)
                                            <option value="{{ $item->id }}">{{ $item->nombreRubro }}</option>
                                            @endforeach
                                        </select>
                                        @error('rubro_id.{{ $value }}') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input wire:model="valorUnitario.{{ $value }}" type="number" class="form-control" id="valorUnitario.{{ $value }}" placeholder="Valor unitario">
                                        @if(isset($valorUnitario[$value]))
                                            @if($valorUnitario[$value] != null)
                                        <span class="badge badge-primary">{{number_format($valorUnitario[$value], 2, ',', '.')}}</span>
                                            @endif
                                        @endif
                                        @error('valorUnitario.{{ $value }}') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input wire:model="cantidad.{{ $value }}" type="number" class="form-control" id="cantidad.{{ $value }}" placeholder="Cantidad">
                                        @error('cantidad.{{ $value }}') <span class="error text-danger">{{ $message }}</span> @enderror
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