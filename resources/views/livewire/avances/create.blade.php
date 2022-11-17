<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createDataModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="createDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDataModalLabel">Crear nuevo Avance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
           <div class="modal-body">
				<form>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="proyecto_id">Proyecto</label>
                                <select wire:model="proyecto_id" id="proyecto_id" class="form-control">
                                    <option value="">-Seleccione una opción-</option>
                                    @foreach ($proyectos as $row)
                                    <option value="{{$row->id}}">{{$row->nombreProyecto}}</option>
                                    @endforeach
                                </select>
                                @error('proyecto_id') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="resultado_id">Resultados</label>
                                <select wire:model="resultado_id" id="resultado_id" class="form-control">
                                    <option value="">-Seleccione una opción-</option>
                                    @if($proyecto_id != null)
                                    @foreach ($resultados as $row)
                                    <option value="{{$row->id}}">{{$row->nombreResultado}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('resultado_id') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="actividad_id">Actividades</label>
                                <select wire:model="actividad_id" id="actividad_id" class="form-control">
                                    <option value="">-Seleccione una opción-</option>
                                    @if($resultado_id != null)
                                    @foreach ($actividades as $row)
                                    <option value="{{$row->id}}">{{$row->nombreActividad}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('actividad_id') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <!-- ACTIVIDADES FILTRADAS -->
                    @if($actividad_id != null)
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            Producto: <b>{{$actividad->producto}}</b>
                        </div>
                        <div class="col-md-2">
                            Presupuesto:
                        </div>
                        <div class="col-md-2">
                            <h4><span class="badge badge-success">$ {{ number_format($actividad->valorTotalActividad, 2, ',', '.') }}</span></h4>
                        </div>
                        <div class="col-md-2">
                            Ponderación:
                        </div>
                        <div class="col-md-2">
                            <h4><span class="badge badge-primary">{{$actividad->ponderacion}}%</span></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 table-responsive p-0">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <th>Rubro</th>
                                    <th>Descripción</th>
                                    <th>Valor Asignado</th>
                                    <th>Valor Anticipo</th>
                                    <th>Legalizado</th>
                                    <th>Responsable</th>
                                </thead>
                                <tbody>
                                    @php
                                        $total_valorAsignado = 0;
                                        $total_valorAnticipo = 0;
                                    @endphp
                                    @foreach ($avances_filtrados as $row)
                                    <tr>
                                        <td>{{ $row->nombreRubro }}</td>
                                        <td>{{ $row->descripcion }}</td>
                                        <td>${{ number_format($row->valorAsignado, '2', ',', '.') }}</td>
                                        <td>${{ number_format($row->valorAnticipo, '2', ',', '.') }}</td>
                                        <td>
                                            @if($row->legalizado == 1)
                                                <span class="badge badge-info">Registro</span>
                                            @elseif($row->legalizado == 2)
                                                <span class="badge badge-info">Solicitud Anticipo</span>
                                            @elseif($row->legalizado == 3)
                                                <span class="badge badge-info">Aprobar Anticipo</span>
                                            @elseif($row->legalizado == 4)
                                                <span class="badge badge-info">Revisión Anticipo</span>
                                            @elseif($row->legalizado == 5)
                                                <span class="badge badge-info">Cargar Giro Anticipo</span>
                                            @elseif($row->legalizado == 6)
                                                <span class="badge badge-info">Aprobación Giro Anticipo</span>
                                            @elseif($row->legalizado == 7)
                                                <span class="badge badge-info">Legalizado</span>
                                            @elseif($row->legalizado == 0)
                                                <span class="badge badge-danger">Devuelto</span>
                                            @else
                                                <span class="badge badge-warning">Sin registro</span>
                                            @endif
                                        </td>
                                        <td>{{ $row->nombres }} {{ $row->apellidos }}</td>
                                        @php
                                            $total_valorAsignado += $row->valorAsignado;
                                            $total_valorAnticipo += $row->valorAnticipo;
                                        @endphp
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <th colspan="2">Total</th>
                                    <th>${{ number_format($total_valorAsignado, '2', ',', '.') }}</th>
                                    <th>${{ number_format($total_valorAnticipo, '2', ',', '.') }}</th>
                                    <th colspan="2"></th>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <hr>
                    @endif
                    <!-- /.ACTIVIDADES FILTRADAS -->
                    <div class="row">
                        <div class="col-md-4">
                            <label for="nombre_rubro">Nombre Rubro</label>
                            <input type="text" wire:model="nombre_rubro" class="form-control">
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="rubro_id">Rubro</label>
                                <select wire:model="rubro_id" id="rubro_id" class="form-control">
                                    <option value="">-Seleccione una opción-</option>
                                    @foreach ($rubros as $row)
                                    <option value="{{$row->id}}">{{$row->codigoContable}}-{{$row->nombreRubro}}</option>
                                    @endforeach
                                </select>
                                @error('rubro_id') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>                    
                    <div class="form-group">
                        <label for="descripcion">Descripcion</label>
                        <textarea wire:model="descripcion" id="descripcion" rows="5" class="form-control"></textarea>
                        @error('descripcion') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="valorAsignado">Valor asignado</label>
                                <input wire:model="valorAsignado" type="text" class="form-control" id="valorAsignado" placeholder="Valorasignado">
                                    @if($valorAsignado !=null)
                                    <span class="badge badge-primary">{{number_format($valorAsignado, 2, ',', '.')}}</span>
                                    @endif
                                @error('valorAsignado') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="empleado_id">Empleado Responsable</label>
                                <select wire:model="empleado_id" id="empleado_id" class="form-control" >
                                    <option>-Seleccione una opción-</option>
                                    @foreach ($empleados as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombres }} {{ $item->apellidos }} - {{ $item->nombreArea }} - {{ $item->nombreOrganizacion }}</option>
                                    @endforeach
                                </select>
                                @error('empleado_id') <span class="error text-danger">{{ $message }}</span> @enderror
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
