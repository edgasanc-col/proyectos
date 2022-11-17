<!-- Modal -->
<div wire:ignore.self class="modal fade" id="showModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="showDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showDataModalLabel">Ver Proyecto: {{$nombreProyecto}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
           <div class="modal-body">
				<form>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="nombreProyecto">Nombre Proyecto</label>
                                <input wire:model="nombreProyecto" type="text" class="form-control" id="nombreProyecto" placeholder="Nombreproyecto" disabled>
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
                                <input wire:model="fechaInicio" type="date" class="form-control" id="fechaInicio" placeholder="Fechainicio" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fechaFin">Fecha fin</label>
                                <input wire:model="fechaFin" type="date" class="form-control" id="fechaFin" placeholder="Fechafin" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="porcentajeDesviacion">Porcentaje desviación</label>
                                <input wire:model="porcentajeDesviacion" type="text" class="form-control" id="porcentajeDesviacion" placeholder="Porcentajedesviacion" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="area_id">Seleccione un Área</label>
                                <select wire:model="area_id" id="area_id" class="form-control" disabled>
                                    <option>-Seleccione una opción-</option>
                                    @foreach ($areas as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombreArea }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <h5>Fuentes Financiación</h5>
                    @for($i = 0; $i < $count; $i++)
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="valorMonedaLocal.">Valor Moneda Local</label>
                                <input wire:model="valorMonedaLocal.{{$i}}" type="number" class="form-control" id="valorMonedaLocal.{{$i}}" placeholder="valorMonedaLocal" disabled>
                                @if($valorMonedaLocal != null)
                                    @if($valorMonedaLocal[$i] !=null)
                                <span class="badge badge-primary">{{number_format($valorMonedaLocal[$i], 2, ',', '.')}}</span>
                                    @endif
                                @endif
                                @error('valorMonedaLocal.'.$i) <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="valorMonedaExtranjera.{{$i}}">Valor Moneda Extranjera</label>
                                <input wire:model="valorMonedaExtranjera.{{$i}}" type="number" class="form-control" id="valorMonedaExtranjera.{{$i}}" placeholder="valorMonedaExtranjera" disabled>
                                @if($valorMonedaExtranjera != null)
                                    @if($valorMonedaExtranjera[$i] !=null)
                                <span class="badge badge-primary">{{number_format($valorMonedaExtranjera[$i], 2, ',', '.')}}</span>
                                    @endif
                                @endif
                                @error('valorMonedaExtranjera.'.$i) <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="donante_id.{{$i}}">Seleccione un Donante</label>
                                <select wire:model="donante_id.{{$i}}" id="donante_id.{{$i}}" class="form-control" disabled>
                                    <option>-Seleccione una opción-</option>
                                    @foreach ($donantes as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombreDonante }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div> 
                    @endfor
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
