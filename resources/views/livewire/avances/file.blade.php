<!-- Modal -->
<div wire:ignore.self class="modal fade" id="fileModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="fileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
       <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fileModalLabel">Documentos Soporte</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span wire:click.prevent="cancel()" aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-border table-sm">
                        <thead>
                            <th>Descripción</th>
                            <th width="20%">Archivo</th>
                        </thead>
                        <tbody>
                            @if($fileMode == true)
                            @foreach ($archivos as $row)
                            <tr>
                                <td>{{$row->observacion}}</td>
                                <td><a href="{{asset('storage/archivos/'.$row->archivo)}}" target="_blank" class="btn btn-info btn-sm btn-block">Ver archivo</a></td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-body">
                <form>
					<input type="hidden" wire:model="selected_id">
                    <div class="form-group">
                        <label for="observacion">Observación</label>
                        <input wire:model="observacion" type="text" id="observacion" class="form-control" placeholder="Ingrese la descripción del archivo">
                        @error('observacion') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="archivo">Archivo</label>
                        <input wire:model="archivo" id="archivo" type="file" class="form-control">
                        <div wire:loading wire:target="archivo"><span class="badge badge-danger">Uploading...</span></div>
                        @error('archivo') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" wire:click.prevent="savefile()" class="btn btn-primary" data-dismiss="modal">Guardar</button>
            </div>
       </div>
    </div>
</div>
