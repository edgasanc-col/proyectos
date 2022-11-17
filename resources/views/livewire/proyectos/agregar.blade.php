<!-- Modal -->
<div wire:ignore.self class="modal fade" id="agregarModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="agregarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarModalLabel">Añadir Presupuesto al Proyecto: @if($proyecto != NULL) {{$proyecto->nombreProyecto}} @endif</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" wire:model="selected_id">
                    <div class="add-input">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="valorMonedaLocal.0">Valor Moneda Local</label>
                                    <input wire:model="valorMonedaLocal.0" type="number" class="form-control" id="valorMonedaLocal.0" placeholder="valorMonedaLocal">
                                    @if($valorMonedaLocal !=null)
                                        @if($valorMonedaLocal[0] !=null)
                                    <span class="badge badge-primary">{{number_format($valorMonedaLocal[0], 2, ',', '.')}}</span>
                                        @endif
                                    @endif
                                    @error('valorMonedaLocal.0') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="valorMonedaExtranjera.0">Valor Moneda Extranjera</label>
                                    <input wire:model="valorMonedaExtranjera.0" type="number" class="form-control" id="valorMonedaExtranjera.0" placeholder="valorMonedaExtranjera">
                                    @if($valorMonedaExtranjera !=null)
                                        @if($valorMonedaExtranjera[0] !=null)
                                    <span class="badge badge-primary">{{number_format($valorMonedaExtranjera[0], 2, ',', '.')}}</span>
                                        @endif
                                    @endif
                                    @error('valorMonedaExtranjera.0') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="valorTRM.0">Valor Moneda Extranjera</label>
                                    <input wire:model="valorTRM.0" type="number" class="form-control" id="valorTRM.0" placeholder="Valor TRM">
                                    @if($valorTRM !=null)
                                        @if($valorTRM[0] !=null)
                                    <span class="badge badge-primary">{{number_format($valorTRM[0], 2, ',', '.')}}</span>
                                        @endif
                                    @endif
                                    @error('valorTRM.0') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="donante_id.0">Seleccione un Donante</label>
                                    <select wire:model="donante_id.0" id="donante_id.0" class="form-control select2" >
                                        <option>-Seleccione una opción-</option>
                                        @foreach ($donantes as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombreDonante }}</option>
                                        @endforeach
                                    </select>
                                    @error('donante_id.0') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button class="btn text-white btn-info btn-block mt-4"  wire:click.prevent="add({{$i}})">Añadir Presupuesto</button>
                            </div>
                        </div>
                    </div>
                    @foreach($inputs as $key =>$value)
                        <div class=" add_input">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input wire:model="valorMonedaLocal.{{ $value }}" type="number" class="form-control" id="valorMonedaLocal.{{ $value }}" placeholder="Valor Moneda Local">
                                        @if(isset($valorMonedaLocal[$value]))
                                            @if($valorMonedaLocal[$value] != null)
                                        <span class="badge badge-primary">{{number_format($valorMonedaLocal[$value], 2, ',', '.')}}</span>
                                            @endif
                                        @endif
                                        @error('valorMonedaLocal.{{ $value }}') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input wire:model="valorMonedaExtranjera.{{ $value }}" type="number" class="form-control" id="valorMonedaExtranjera.{{ $value }}" placeholder="Valor Moneda Extranjera">
                                        @if(isset($valorMonedaExtranjera[$value]))
                                            @if($valorMonedaExtranjera[$value] != null)
                                        <span class="badge badge-primary">{{number_format($valorMonedaExtranjera[$value], 2, ',', '.')}}</span>
                                            @endif
                                        @endif
                                        @error('valorMonedaExtranjera.{{ $value }}') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input wire:model="valorTRM.{{ $value }}" type="number" class="form-control" id="valorTRM.{{ $value }}" placeholder="Valor TRM">
                                        @if(isset($valorTRM[$value]))
                                            @if($valorTRM[$value] != null)
                                        <span class="badge badge-primary">{{number_format($valorTRM[$value], 2, ',', '.')}}</span>
                                            @endif
                                        @endif
                                        @error('valorTRM.{{ $value }}') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select wire:model="donante_id.{{ $value }}" id="donante_id.{{ $value }}" class="form-control select2" >
                                            <option>-Seleccione una opción-</option>
                                            @foreach ($donantes as $item)
                                            <option value="{{ $item->id }}">{{ $item->nombreDonante }}</option>
                                            @endforeach
                                        </select>
                                        @error('donante_id.') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>   
                                <div class="col-md-3">
                                    <button class="btn btn-danger btn-block" wire:click.prevent="remove({{$key}})">Eliminar</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </form>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-secondary" role="alert">
                            <b>Nota: </b> En caso de que una fuente de financiación tenga varios desembolsos durante la ejecución del contrato, no se debe registrar como única sino en la cantidad de desembolsos pactados con el donante.
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" wire:click.prevent="guardaragregar()" class="btn btn-primary" data-dismiss="modal">Añadir</button>
            </div>
        </div>
    </div>
</div>