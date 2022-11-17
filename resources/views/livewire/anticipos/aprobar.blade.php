<!-- Modal -->
<div wire:ignore.self class="modal fade" id="aprobarModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="aprobarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aprobarModalLabel">Registrar Aprobación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <th>Comentario</th>
                                    <th>Legalizado</th>
                                    <th>Usuario</th>
                                    <th>Fecha</th>
                                </thead>
                                <tbody>
                                    @if($anticipo_id != NULL && $aprobarMode == true)
                                    @foreach($aprobacion_anticipos as $row)
                                    <tr>
                                        <td>{{$row->comentario}}</td>
                                        <td>
                                            @if($row->legalizado == 1)
                                                <span class="badge badge-info">Registro</span>
                                            @elseif($row->legalizado == 2)
                                                <span class="badge badge-warning">Solicitud Anticipo</span>
                                            @elseif($row->legalizado == 3)
                                                <span class="badge badge-warning">Aprobar Anticipo</span>
                                            @elseif($row->legalizado == 4)
                                                <span class="badge badge-warning">Revisión Anticipo</span>
                                            @elseif($row->legalizado == 5)
                                                <span class="badge badge-warning">Cargar Giro Anticipo</span>
                                            @elseif($row->legalizado == 6)
                                                <span class="badge badge-warning">Aprobación Giro Anticipo</span>
                                            @elseif($row->legalizado == 7)
                                                <span class="badge badge-success">Legalizado</span>
                                            @elseif($row->legalizado == 0)
                                                <span class="badge badge-danger">Devuelto</span>
                                            @else
                                                <span class="badge badge-info">Sin registro</span>
                                            @endif    
                                        </td>
                                        <td>{{$row->nombres}} {{$row->apellidos}}</td>
                                        <td>{{$row->created_at}}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <form>
                            <input type="hidden" wire:model="anticipo_id" id="anticipo_id">
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <input type="text" wire:model="descripcion" id="descripcion" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                                <label for="valorAnticipo">Valor Anticipo</label>
                                <input type="text" wire:model="valorAnticipo" id="valorAnticipo" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                                <label for="comentario">Comentario</label>
                                <input type="text" wire:model="comentario" id="comentario" class="form-control" placeholder="Comentario de la aprobación del anticipo">
                                @error('comentario') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="legalizado">Legalizado</label>
                                <select wire:model="legalizado" id="legalizado" class="form-control">
                                    <option value="">-Seleccione una opción-</option>
                                    <option value="3">Aprobar Anticipo</option>
                                    <option value="4">Revisión Anticipo</option>
                                    <option value="5">Cargar Giro Anticipo</option>
                                    <option value="6">Aprobación Giro Anticipo</option>
                                    <option value="7">Legalizado</option>
                                    <option value="0">Devuelto</option>
                                </select>
                                @error('legalizado') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Cerrar</button>
                <button type="button" wire:click.prevent="store_aprobacion()" class="btn btn-primary close-modal">Guardar</button>
            </div>
        </div>
    </div>
</div>
