<!-- Modal -->
<div wire:ignore.self class="modal fade" id="showModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="showDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showDataModalLabel">Ver Actividad: {{$nombreActividad}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
				<form>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="progress">
                                <div class="progress-bar {{$color}}" role="progressbar" style="width: {{$ponderacionResultado}}%" aria-valuenow="{{$ponderacionResultado}}" aria-valuemin="0" aria-valuemax="100">
                                    {{$ponderacionResultado}} %
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-2">
                            Presupuesto del Resultado:
                        </div>
                        <div class="col-md-2">
                            <h4><span class="badge badge-info">${{number_format($presupuesto, 2, ',', '.')}}</span></h4>
                        </div>
                        <div class="col-md-2">
                            Recursos comprometidos:
                        </div>
                        <div class="col-md-2">
                            <h4><span class="badge badge-danger">${{number_format($valorTotalActividades, 2, ',', '.')}}</span></h4>
                        </div>
                        <div class="col-md-2">
                            Recursos disponibles:
                        </div>
                        <div class="col-md-2">
                            <h4><span class="badge badge-success">${{number_format(($presupuesto-$valorTotalActividades), 2, ',', '.')}}</span></h4>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nombreActividad">Nombre Actividad</label>
                                <input wire:model="nombreActividad" type="text" class="form-control" id="nombreActividad" placeholder="Nombre actividad" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="producto">Producto de la actividad</label>
                                <input wire:model="producto" type="text" class="form-control" id="producto" placeholder="Producto de la actividad" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="valorTotalActividad">Valor Total Actividad</label>
                                <input wire:model="valorTotalActividad" type="text" class="form-control" id="valorTotalActividad" placeholder="valorTotalActividad" disabled>
                                <span class="badge badge-primary">{{number_format($valorTotalActividad, 2, ',', '.')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="ponderacion">Ponderación</label>
                                <input wire:model="ponderacion" type="numeric" class="form-control" id="ponderacion" placeholder="Ponderacion" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="fecha_ejecucion">Fecha Ejecución</label>
                                <input wire:model="fecha_ejecucion" type="date" class="form-control" id="fecha_ejecucion" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="fecha_limite">Fecha Límite</label>
                                <input wire:model="fecha_limite" type="date" class="form-control" id="fecha_limite" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="fecha_realizacion">Fecha Realización</label>
                                <input wire:model="fecha_realizacion" type="date" class="form-control" id="fecha_realizacion" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="empleado_id">Seleccione un ID Empleado</label>
                                <select wire:model="empleado_id" id="empleado_id" class="form-control select2" disabled>
                                    <option>-Seleccione una opción-</option>
                                    @foreach ($empleados as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombres }} {{ $item->apellidos }} - {{ $item->nombreArea }} - {{ $item->nombreOrganizacion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="resultado_id">Seleccione un Resultado</label>
                                <select wire:model="resultado_id" id="resultado_id" class="form-control select2" disabled>
                                    <option>-Seleccione una opción-</option>
                                    @if($proyecto_id != NULL)
                                    @foreach ($resultados as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombreResultado }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <h5>Rubros Afectados</h5>
                    @for($i = 0; $i < $count; $i++)
                    <div class="add-input">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="rubro_id.{{$i}}">Seleccione un Rubro</label>
                                    <select wire:model="rubro_id.{{$i}}" id="rubro_id.{{$i}}" class="form-control" disabled >
                                        <option>-Seleccione una opción-</option>
                                        @foreach ($rubros as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombreRubro }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="valorUnitario.{{ $i }}">Valor Unitario</label>
                                    <input wire:model="valorUnitario.{{ $i }}" type="number" class="form-control" id="valorUnitario.{{ $i }}" placeholder="Valor unitario" disabled>
                                    @if($valorUnitario != null)
                                        @if($valorUnitario[$i] !=null)
                                    <span class="badge badge-primary">{{number_format($valorUnitario[$i], 2, ',', '.')}}</span>
                                        @endif
                                    @endif
                                    @error('valorUnitario.{{ $i }}') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cantidad.{{$i}}">Cantidad</label>
                                    <input wire:model="cantidad.{{$i}}" type="number" class="form-control" id="cantidad.{{$i}}" placeholder="Cantidad" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="valorTotal.{{$i}}">Valor Total</label>
                                    <input wire:model="valorTotal.{{$i}}" type="number" class="form-control" id="valorTotal.{{$i}}" placeholder="Cantidad" disabled>
                                    @if($valorTotal != null)
                                        @if($valorTotal[$i] !=null)
                                    <span class="badge badge-primary">{{number_format($valorTotal[$i], 2, ',', '.')}}</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endfor
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>