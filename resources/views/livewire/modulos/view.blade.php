@section('title', __('Modulos'))
<div class="container-fluid mt-4">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div style="display: flex; justify-content: space-between; align-items: center;">
						<div class="float-left">
							<h4><i class="fab fa-laravel text-info"></i>
								Registros Módulos </h4>
						</div>
						<div wire:poll.60s>
							<code><h5>{{ now()->format('H:i:s') }} UTC</h5></code>
						</div>
						@if (session()->has('message'))
						<div wire:poll.4s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;"> {{ session('message') }} </div>
						@endif
						<div>
							<input wire:model='keyWord' type="text" class="form-control" name="search" id="search" placeholder="Buscar Modulos">
						</div>
						@if($crear == 1)
						<div class="btn btn-sm btn-info" data-toggle="modal" data-target="#createDataModal">
							<i class="fa fa-plus"></i>  Añadir Modulos
						</div>
						@endif
					</div>
				</div>
				
				<div class="card-body p-0">
						@include('livewire.modulos.create')
						@include('livewire.modulos.update')
				<div class="table-responsive">
					<table class="table table-striped table-sm">
						<thead class="thead">
							<tr> 
								<th>ID</th> 
								<th>Módulo</th>
								<th>User Create</th>
								<th>User Update</th>
								<th>Estado</th>
								<th>Borrado</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($modulos as $row)
							<tr>
								<td>{{ $row->id }}</td> 
								<td>{{ $row->nombreModulo }}</td>
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
								<td>
									@if($editar == 1)
									<button data-toggle="modal" data-target="#updateModal" class="btn btn-default btn-sm" wire:click="edit({{$row->id}})"><i class="fa fa-edit"></i> </button>
									@endif
									@if($borrar == 1)
									<button class="btn btn-default btn-sm"onclick="confirm('Confirm Delete Modulo id {{$row->id}}? \nDeleted Modulos cannot be recovered!')||event.stopImmediatePropagation()" wire:click="destroy({{$row->id}})"><i class="fa fa-trash"></i></button>								
									@endif
								</td>
							@endforeach
						</tbody>
					</table>						
					{{ $modulos->links() }}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
