<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createDataModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="createDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDataModalLabel">Crear nueva Actividad</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
           <div class="modal-body">
				<form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="proyecto_id">Seleccione un Proyecto</label>
                                <select wire:model="proyecto_id" id="proyecto_id" class="form-control" >
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
                                <select wire:model="resultado_id" id="resultado_id" class="form-control" >
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha_ejecucion">Fecha Ejecución</label>
                                <input wire:model="fecha_ejecucion" type="date" class="form-control" id="fecha_ejecucion">
                                @error('fecha_ejecucion') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha_limite">Fecha Límite</label>
                                <input wire:model="fecha_limite" type="date" class="form-control" id="fecha_limite">
                                @error('fecha_limite') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="ponderacion">Ponderación</label>
                                <input wire:model="ponderacion" type="numeric" class="form-control" id="ponderacion" placeholder="Ponderacion">
                                @error('ponderacion') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="empleado_id">Seleccione un ID Empleado</label>
                                <select wire:model="empleado_id" id="empleado_id" class="form-control" >
                                    <option>-Seleccione una opción-</option>
                                    @foreach ($empleados as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombres }} {{ $item->apellidos }} - {{ $item->nombreArea }} - {{ $item->nombreOrganizacion }}</option>
                                    @endforeach
                                </select>
                                @error('empleado_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    @if(isset($resultado_id))
                        @if($resultado_id != null)
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
                    @if($actividades_resultado != null)
                    <div class="row">
                        <div class="col-md-12 mt-4">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <th>Nombre Actividad</th>
                                        <th>Producto</th>
                                        <th>Presupuesto</th>
                                        <th>Ponderación</th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total_ponderacion = 0;
                                            $total_presupuesto = 0;
                                        @endphp
                                        @foreach ($actividades_resultado as $row)
                                        <tr>
                                            <td>{{$row->nombreActividad}}</td>
                                            <td>{{$row->producto}}</td>
                                            <td>{{number_format($row->valorTotalActividad, 2, ',', '.')}}</td>
                                            <td>{{$row->ponderacion}}%</td>
                                        </tr>
                                        @php
                                            $total_ponderacion += $row->ponderacion;
                                            $total_presupuesto += $row->valorTotalActividad;
                                        @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <th colspan="2">Total</th>
                                        <th>{{number_format($total_presupuesto, 2, ',', '.')}}</th>
                                        <th>{{$total_ponderacion}}%</th>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                    <hr>
                    <h5>Rubros Afectados</h5>
                    <div class="add-input">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="rubro">Buscar por nombre rubro</label>
                                <input type="text" wire:model="rubro" id="rubro" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <div class="form-group" @if(isset($rubro_id)) @if($rubro_id[0] != null) wire:ignore @endif @endif>
                                    <label for="rubro_id.0">Seleccione un Rubro</label>
                                    <select wire:model="rubro_id.0" id="rubro_id.0" class="form-control select2">
                                        <option>-Seleccione una opción-</option>
                                        @foreach ($rubros as $item)
                                        <option value="{{ $item->id }}">{{$item->codigoContable}} - {{ $item->nombreRubro }}</option>
                                        @endforeach
                                    </select>
                                    @error('rubro_id.0') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="valorUnitario.0">Valor Unitario</label>
                                    <input wire:model="valorUnitario.0" type="number" class="form-control" id="valorUnitario.0" placeholder="Valor unitario">
                                    @if($valorUnitario != null)    
                                        @if($valorUnitario[0] != null)
                                    <span class="badge badge-primary">{{number_format($valorUnitario[0], 2, ',', '.')}}</span>
                                        @endif
                                    @endif
                                @error('valorUnitario.0') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-1">
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
                                    <input type="text" wire:model="rubro" id="rubro" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" @if(isset($rubro_id[$value])) @if($rubro_id[$value] != null) wire:ignore @endif @endif>
                                        <select wire:model="rubro_id.{{ $value }}" id="rubro_id.{{ $value }}" class="form-control" >
                                            <option>-Seleccione una opción-</option>
                                            @foreach ($rubros as $item)
                                            <option value="{{ $item->id }}">{{$item->codigoContable}} - {{ $item->nombreRubro }}</option>
                                            @endforeach
                                        </select>
                                        @error('rubro_id.{{ $value }}') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
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
                                <div class="col-md-1">
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
                        @endif
                    @endif
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary close-btn" data-dismiss="modal">Cerrar</button>
                <button type="button" wire:click.prevent="store()" class="btn btn-primary close-modal">Guardar</button>
            </div>
        </div>
    </div>
</div>