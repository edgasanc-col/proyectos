<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
       <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Actualizar Anticipo - @if($avance_id != NULL){{$avance->descripcion}}@endif</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span wire:click.prevent="cancel()" aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
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
                <form>
					<input type="hidden" wire:model="selected_id">
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
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" wire:click.prevent="update()" class="btn btn-primary" data-dismiss="modal">Guardar</button>
            </div>
       </div>
    </div>
</div>
