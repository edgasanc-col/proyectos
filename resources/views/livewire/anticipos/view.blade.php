@section('title', __('Anticipos'))
<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div style="display: flex; justify-content: space-between; align-items: center;">
						<div class="float-left">
							<h4><i class="fab fa-laravel text-info"></i>
							Anticipo</h4>
						</div>
						@if (session()->has('message'))
						<div wire:poll.4s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;"> {{ session('message') }} </div>
						@endif
						<div>
							<input wire:model='keyWord' type="text" class="form-control" name="search" id="search" placeholder="Buscar Anticipos">
						</div>
						@if($crear == 1)
						<div class="btn btn-sm btn-info" data-toggle="modal" data-target="#createDataModal">
							<i class="fa fa-plus"></i>  Añadir Anticipos
						</div>
						@endif
					</div>
				</div>
				
				<div class="card-body p-0">
						@include('livewire.anticipos.create')
						@include('livewire.anticipos.update')
						@include('livewire.anticipos.aprobar')
				<div class="table-responsive">
					<table class="table table-striped table-sm">
						<thead class="thead">
							<tr> 
								<th>#</th> 
								<th>Valor Anticipo</th>
								<th>Descripcion</th>
								<th>Legalizado</th>
								<th>Avance</th>
								<th>User Create</th>
								<th>User Update</th>
								<th>Estado</th>
								<th>Borrado</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($anticipos as $row)
							<tr>
								<td>{{ $row->id }}</td> 
								<td>${{ number_format($row->valorAnticipo, '2', ',', '.') }}</td>
								<td>{{ $row->descripcion }}</td>
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
								<td>{{ $row->adescripcion }}</td>
								<td>{{ $row->ucnombres }} {{ $row->ucapellidos }}</td>
								<td>{{ $row->uunombres }} {{ $row->uuapellidos }}</td>
								<td>
									@if($row->estado == 1)
										<span class="badge badge-success">Activo</span>
									@else
										<span class="badge badge-danger">Inactivo</span>
									@endif	
								</td>
								<td>
									@if($row->borrado == 1)
										<span class="badge badge-danger">Si</span>
									@else
										<span class="badge badge-primary">No</span>
									@endif
								</td>
								<td width="11%">
									<button data-toggle="modal" data-target="#aprobarModal" class="btn btn-default btn-sm" wire:click="aprobar({{$row->id}})"><i class="fa fa-check"></i></button>
									@if($editar == 1)
									<button data-toggle="modal" data-target="#updateModal" class="btn btn-default btn-sm" wire:click="edit({{$row->id}})"><i class="fa fa-edit"></i></button>
									@endif
									@if($borrar == 1)
									<button class="btn btn-default btn-sm" onclick="confirm('Confirma borrar el registro Anticipo id {{$row->id}}? \nDeleted Anticipos cannot be recovered!')||event.stopImmediatePropagation()" wire:click="destroy({{$row->id}})"><i class="fa fa-trash"></i></button>
									@endif
								</td>
							@endforeach
						</tbody>
					</table>						
					{{ $anticipos->links() }}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
