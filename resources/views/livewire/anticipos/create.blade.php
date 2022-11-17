<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createDataModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="createDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDataModalLabel">Crear nuevo Anticipo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
           <div class="modal-body">
				<form>
                    <div class="row">
                        <div class="col-md-6">
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
                        <div class="col-md-6">
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
                        <div class="col-md-6">
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="avance_id">Avances</label>
                                <select wire:model="avance_id" id="avance_id" class="form-control">
                                    <option value="">-Seleccione una opción-</option>
                                    @if($resultado_id != null)
                                    @foreach ($avances as $row)
                                    <option value="{{$row->id}}">{{$row->descripcion}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('actividad_id') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    @if($avance_id != NULL)
                    <div class="row">
                        <div class="col-md-3">
                            <b>Valor Asignado</b>
                        </div>
                        <div class="col-md-3">
                            <span class="badge badge-primary">${{number_format($avance->valorAsignado, '2', '.', ',')}}</span>
                        </div>
                        <div class="col-md-3">
                            <b>Valor Anticipo</b>
                        </div>
                        <div class="col-md-3">
                            <span class="badge badge-success">${{number_format($avance->valorAnticipo, '2', '.', ',')}}</span>
                        </div>
                    </div>
                    <hr>
                    @endif
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="valorAnticipo">Valor Anticipo</label>
                                <input wire:model="valorAnticipo" type="text" class="form-control" id="valorAnticipo" placeholder="Valoranticipo">
                                    @if($valorAnticipo !=null)
                                    <span class="badge badge-primary">{{number_format($valorAnticipo, 2, ',', '.')}}</span>
                                    @endif
                                @error('valorAnticipo') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nit">NIT / Cédula</label>
                                <input wire:model="nit" type="number" class="form-control" id="nit" placeholder="nit">
                                @error('nit') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="razon_social">Razón Social / Nombres</label>
                                <input wire:model="razon_social" type="text" class="form-control" id="razon_social" placeholder="Razon Social">
                                @error('razon_social') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="descripcion">Descripcion</label>
                                <input wire:model="descripcion" type="text" class="form-control" id="descripcion" placeholder="Descripcion">
                                @error('descripcion') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <input wire:model="avance_id" type="hidden" id="avance_id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Cerrar</button>
                <button type="button" wire:click.prevent="store()" class="btn btn-primary close-modal">Guardar</button>
            </div>
        </div>
    </div>
</div>
