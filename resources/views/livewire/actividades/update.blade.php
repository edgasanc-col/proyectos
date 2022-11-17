<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
       <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Actualizar Actividad</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span wire:click.prevent="cancel()" aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
					<input type="hidden" wire:model="selected_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombreActividad">Nombre Actividad</label>
                                <input wire:model="nombreActividad" type="text" class="form-control" id="nombreActividad" placeholder="Nombre actividad">
                                @error('nombreActividad') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="producto">Producto de la actividad</label>
                                <input wire:model="producto" type="text" class="form-control" id="producto" placeholder="Producto de la actividad">
                                @error('producto') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="valorTotalActividad">Valor Total Actividad</label>
                                <input wire:model="valorTotalActividad" type="text" class="form-control" id="valorTotalActividad" placeholder="Valor unitario" disabled>
                                <span class="badge badge-primary">{{number_format($valorTotalActividad, 2, ',', '.')}}</span>
                                @error('valorTotalActividad') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="ponderacion">Ponderación</label>
                                <input wire:model="ponderacion" type="text" class="form-control" id="ponderacion" placeholder="Ponderacion">
                                @error('ponderacion') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="empleado_id">Seleccione un empleado</label>
                                <select wire:model="empleado_id" id="empleado_id" class="form-control select2" >
                                    <option>-Seleccione una opción-</option>
                                    @foreach ($empleados as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombres }} {{ $item->apellidos }} - {{ $item->nombreArea }} - {{ $item->nombreOrganizacion }}</option>
                                    @endforeach
                                </select>
                                @error('empleado_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="@if($presupuesto-$valorTotalActividades <= 0) col-md-4 @else col-md-6 @endif">
                            <div class="form-group">
                                <label for="fecha_ejecucion">Fecha Ejecución</label>
                                <input wire:model="fecha_ejecucion" type="date" class="form-control" id="fecha_ejecucion">
                                @error('fecha_ejecucion') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="@if($presupuesto-$valorTotalActividades <= 0) col-md-4 @else col-md-6 @endif">
                            <div class="form-group">
                                <label for="fecha_limite">Fecha Límite</label>
                                <input wire:model="fecha_limite" type="date" class="form-control" id="fecha_limite">
                                @error('fecha_limite') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        @if($presupuesto-$valorTotalActividades <= 0)
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fecha_realizacion">Fecha Realización</label>
                                <input wire:model="fecha_realizacion" type="date" class="form-control" id="fecha_realizacion">
                                @error('fecha_realizacion') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="proyecto_id">Seleccione un Proyecto</label>
                                <select wire:model="proyecto_id" id="proyecto_id" class="form-control select2" >
                                    <option>-Seleccione una opción-</option>
                                    @foreach ($proyectos as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombreProyecto }}</option>
                                    @endforeach
                                </select>
                                @error('proyecto_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="resultado_id">Seleccione un Resultado</label>
                                <select wire:model="resultado_id" id="resultado_id" class="form-control select2" >
                                    <option>-Seleccione una opción-</option>
                                    @if($this->proyecto_id != NULL)
                                    @foreach ($resultados as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombreResultado }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('resultado_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <hr>
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
                    <h5>Rubros Afectados</h5>
                    @for($i = 0; $i < $count; $i++)
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="rubro_id.{{$i}}">Seleccione un Rubro</label>
                                <select wire:model="rubro_id.{{$i}}" id="rubro_id.{{$i}}" class="form-control select2" >
                                    <option>-Seleccione una opción-</option>
                                    @foreach ($rubros as $item)
                                    <option value="{{ $item->id }}">{{ $item->codigoContable }} - {{ $item->nombreRubro }}</option>
                                    @endforeach
                                </select>
                                @error('rubro_id.'.$i) <span class="text-danger">{{ $message }}</span> @enderror
                                <input type="hidden" wire:model="actividad_rubro_id.{{$i}}" id="actividad_rubro_id.{{$i}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="valorUnitario.{{ $i }}">Valor Unitario</label>
                                <input wire:model="valorUnitario.{{ $i }}" type="number" class="form-control" id="valorUnitario.{{ $i }}" placeholder="Valor unitario">
                                @if($valorUnitario != null)
                                    @if($valorUnitario[$i] !=null)
                                <span class="badge badge-primary">{{number_format($valorUnitario[$i], 2, ',', '.')}}</span>
                                    @endif
                                @endif
                                @error('valorUnitario.{{ $i }}') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cantidad.{{ $i }}">Cantidad</label>
                                <input wire:model="cantidad.{{ $i }}" type="number" class="form-control" id="cantidad.{{ $i }}" placeholder="Cantidad">
                                @error('cantidad.{{ $i }}') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    @endfor

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" wire:click.prevent="update()" class="btn btn-primary" data-dismiss="modal">Guardar</button>
            </div>
       </div>
    </div>
</div>
