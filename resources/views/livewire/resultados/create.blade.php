<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createDataModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="createDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDataModalLabel">Crear nuevo Resultado</h5>
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
                                <label for="nombreResultado">Nombre Resultado</label>
                                <input wire:model="nombreResultado" type="text" class="form-control" id="nombreResultado" placeholder="Nombreresultado">
                                @error('nombreResultado') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombreIndicador">Nombre Indicador</label>
                                <input wire:model="nombreIndicador" type="text" class="form-control" id="nombreIndicador" placeholder="Nombreindicador">
                                @error('nombreIndicador') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="presupuesto">Presupuesto</label>
                                <input wire:model="presupuesto" type="number" class="form-control" id="presupuesto" placeholder="Presupuesto">
                                <span class="badge badge-primary">{{number_format($presupuesto, 2, ',', '.')}}</span>
                                @error('nombreIndicador') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="ponderacion">Ponderación</label>
                                <input wire:model="ponderacion" type="number" class="form-control" id="ponderacion" placeholder="Ponderación">
                                @error('ponderacion') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="alert alert-secondary" role="alert">
                                <b>Nota: </b> La ponderación del resultado corresponde al <i>peso del resultado</i> en términos porcentuales sobre el proyecto.
                            </div>
                        </div>
                    </div>
                    @if($proyecto_id != null)
                    <hr>
                    <div class="row">
                        <div class="col-md-2">
                            Presupuesto del Proyecto:
                        </div>
                        <div class="col-md-2">
                            <h4><span class="badge badge-info">${{number_format($valorTotalProyecto, 2, ',', '.')}}</span></h4>
                        </div>
                        <div class="col-md-2">
                            Recursos comprometidos:
                        </div>
                        <div class="col-md-2">
                            <h4><span class="badge badge-danger">${{number_format($valorComprometido, 2, ',', '.')}}</span></h4>
                        </div>
                        <div class="col-md-2">
                            Recursos disponibles:
                        </div>
                        <div class="col-md-2">
                            <h4><span class="badge badge-success">${{number_format(($valorTotalProyecto-$valorComprometido), 2, ',', '.')}}</span></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-4">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <th>Nombre Resultado</th>
                                        <th>Nombre Indicador</th>
                                        <th>Recursos comprometidos</th>
                                        <th>Ponderación</th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total_ponderacion = 0;
                                            $total_presupuesto = 0;
                                        @endphp
                                        @foreach ($resultados_proyecto as $row)
                                        <tr>
                                            <td>{{$row->nombreResultado}}</td>
                                            <td>{{$row->nombreIndicador}}</td>
                                            <td>{{number_format($row->presupuesto, 2, ',', '.')}}</td>
                                            <td>{{$row->ponderacion}}%</td>
                                        </tr>
                                        @php
                                            $total_ponderacion += $row->ponderacion;
                                            $total_presupuesto += $row->presupuesto;
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
                    <hr>
                    @if(($valorTotalProyecto-$valorComprometido) == 0)
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Holy guacamole!</strong> El presupuesto se ha comprometido en su totalidad.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @else
                    <h5>Responsables</h5>
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
                    @endif
                    @endif
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Cerrar</button>
                <button type="button" wire:click.prevent="store()" class="btn btn-primary close-modal">Guardar</button>
            </div>
        </div>
    </div>
</div>
