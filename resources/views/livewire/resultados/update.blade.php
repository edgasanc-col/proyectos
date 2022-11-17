<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
       <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Actualizar Resultado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span wire:click.prevent="cancel()" aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
					<div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombreResultado">Nombre Resultado</label>
                                <input wire:model="nombreResultado" type="text" class="form-control" id="nombreResultado" placeholder="Nombreresultado">
                                @error('nombreResultado') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombreIndicador">Nombre Indicador</label>
                                <input wire:model="nombreIndicador" type="text" class="form-control" id="nombreIndicador" placeholder="Nombreindicador">
                                @error('nombreIndicador') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
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
                        <div class="col-md-4">
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
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="estado">Estado</label>
                                <select wire:model="estado" id="estado" class="form-control">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
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
                    <hr>
                    @endif
                    <h5>Responsables</h5>
                    @for($i = 0; $i < $count; $i++)
                    <div class="form-group">
                        <label for="empleado_id.{{$i}}">Seleccione un empleado</label>
                        <select wire:model="empleado_id.{{ $i }}" id="empleado_id.{{ $i }}" class="form-control select2" >
                            <option>-Seleccione una opción-</option>
                            @foreach ($empleados as $item)
                            <option value="{{ $item->id }}">{{ $item->nombres }} {{$item->apellidos}} - {{$item->nombreArea}} - {{$item->nombreOrganizacion}}</option>
                            @endforeach
                        </select>
                        @error('empleado_id.'.$i) <span class="text-danger">{{ $message }}</span> @enderror
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
