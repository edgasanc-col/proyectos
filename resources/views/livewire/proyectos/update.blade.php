<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
       <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Actualizar Proyecto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span wire:click.prevent="cancel()" aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="nombreProyecto">Nombre Proyecto</label>
                                <input wire:model="nombreProyecto" type="text" class="form-control" id="nombreProyecto" placeholder="Nombreproyecto">
                                @error('nombreProyecto') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="valorTotalProyecto">Valor Proyecto</label>
                                <input wire:model="valorTotalProyecto" type="number" class="form-control" id="valorTotalProyecto" placeholder="Nombreproyecto" disabled>
                                <span class="badge badge-primary">{{number_format($valorTotalProyecto, 2, ',', '.')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fechaInicio">Fecha inicio</label>
                                <input wire:model="fechaInicio" type="date" class="form-control" id="fechaInicio" placeholder="Fechainicio">@error('fechaInicio') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fechaFin">Fecha fin</label>
                                <input wire:model="fechaFin" type="date" class="form-control" id="fechaFin" placeholder="Fechafin">@error('fechaFin') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="porcentajeDesviacion">Porcentaje desviación</label>
                                <input wire:model="porcentajeDesviacion" type="text" class="form-control" id="porcentajeDesviacion" placeholder="Porcentajedesviacion">@error('porcentajeDesviacion') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="area_id">Seleccione un Área</label>
                                <select wire:model="area_id" id="area_id" class="form-control" multiple>
                                    <option>-Seleccione una opción-</option>
                                    @foreach ($areas as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombreArea }}</option>
                                    @endforeach
                                </select>
                                @error('area_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select wire:model="estado" id="estado" class="form-control">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    <h5>Fuentes Financiación</h5>
                    @for($i = 0; $i < $count; $i++)
                    <div class="row">
                        <input type="hidden" wire:model="proyecto_presupuesto_id.{{$i}}">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="valorMonedaLocal.">Valor Moneda Local</label>
                                <input wire:model="valorMonedaLocal.{{$i}}" type="number" class="form-control" id="valorMonedaLocal.{{$i}}" placeholder="valorMonedaLocal">
                                @if($valorMonedaLocal != null)
                                    @if($valorMonedaLocal[$i] !=null)
                                <span class="badge badge-primary">{{number_format($valorMonedaLocal[$i], 2, ',', '.')}}</span>
                                    @endif
                                @endif
                                @error('valorMonedaLocal.'.$i) <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="valorMonedaExtranjera.{{$i}}">Valor Moneda Extranjera</label>
                                <input wire:model="valorMonedaExtranjera.{{$i}}" type="number" class="form-control" id="valorMonedaExtranjera.{{$i}}" placeholder="valorMonedaExtranjera">
                                @if($valorMonedaExtranjera != null)
                                    @if($valorMonedaExtranjera[$i] !=null)
                                <span class="badge badge-primary">{{number_format($valorMonedaExtranjera[$i], 2, ',', '.')}}</span>
                                    @endif
                                @endif
                                @error('valorMonedaExtranjera.'.$i) <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="valorTRM.{{$i}}">Valor TRM</label>
                                <input wire:model="valorTRM.{{$i}}" type="number" class="form-control" id="valorTRM.{{$i}}" placeholder="Valor TRM">
                                @if($valorTRM != null)
                                    @if($valorTRM[$i] !=null)
                                <span class="badge badge-primary">{{number_format($valorTRM[$i], 2, ',', '.')}}</span>
                                    @endif
                                @endif
                                @error('valorTRM.'.$i) <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="donante_id.{{$i}}">Seleccione un Donante</label>
                                <select wire:model="donante_id.{{$i}}" id="donante_id.{{$i}}" class="form-control select2" >
                                    <option>-Seleccione una opción-</option>
                                    @foreach ($donantes as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombreDonante }}</option>
                                    @endforeach
                                </select>
                                @error('donante_id.'.$i ) <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div> 
                    @endfor
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-secondary" role="alert">
                                <b>Nota: </b> En caso de que una fuente de financiación tenga varios desembolsos durante la ejecución del contrato, no se debe registrar como única sino en la cantidad de desembolsos pactados con el donante.
                            </div>
                        </div>
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
