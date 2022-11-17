@section('title', __('Departamentos'))
<div class="container-fluid mt-4">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div style="display: flex; justify-content: space-between; align-items: center;">
						<div class="float-left">
							<h4><i class="fab fa-laravel text-info"></i>
							Listado Departamentos</h4>
						</div>
						@if (session()->has('message'))
						<div wire:poll.4s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;"> {{ session('message') }} </div>
						@endif
						<div>
							<input wire:model='keyWord' type="text" class="form-control" name="search" id="search" placeholder="Buscar Departamentos">
						</div>
						@if($crear == 1)
						<div class="btn btn-sm btn-info" data-toggle="modal" data-target="#createDataModal">
							<i class="fa fa-plus"></i>  Añadir Departamentos
						</div>
						@endif
					</div>
				</div>
				
				<div class="card-body p-0">
						@include('livewire.departamentos.create')
						@include('livewire.departamentos.update')
				<div class="table-responsive">
					<table class="table table-striped table-sm">
						<thead class="thead">
							<tr> 
								<th>ID</th> 
								<th>Código departamento</th>
								<th>Nombre departamento</th>
								<th>País</th>
								<th>User Create</th>
								<th>User Update</th>
								<th>Estado</th>
								<th>Borrado</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($departamentos as $row)
							<tr>
								<td>{{ $row->id }}</td> 
								<td>{{ $row->codigoDepartamento }}</td>
								<td>{{ $row->nombreDepartamento }}</td>
								<td>{{ $row->nombrePais }}</td>
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
									<button class="btn btn-default btn-sm"onclick="confirm('Confirm Delete Departamento id {{$row->id}}? \nDeleted Departamentos cannot be recovered!')||event.stopImmediatePropagation()" wire:click="destroy({{$row->id}})"><i class="fa fa-trash"></i></button>								
									@endif
								</td>
							@endforeach
						</tbody>
					</table>						
					{{ $departamentos->links() }}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
