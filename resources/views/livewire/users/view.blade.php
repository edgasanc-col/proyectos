@section('title', __('Users'))
<div class="container-fluid mt-4">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div style="display: flex; justify-content: space-between; align-items: center;">
						<div class="float-left">
							<h4><i class="fab fa-laravel text-info"></i>
							Listado de Usuarios </h4>
						</div>
						<div wire:poll.60s>
							<code><h5>{{ now()->format('H:i:s') }} UTC</h5></code>
						</div>
						@if (session()->has('message'))
						<div wire:poll.4s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;"> {{ session('message') }} </div>
						@endif
						<div>
							<input wire:model='keyWord' type="text" class="form-control" name="search" id="search" placeholder="Search Users">
						</div>
						@if($crear == 1)
						<div class="btn btn-sm btn-info" data-toggle="modal" data-target="#createDataModal">
							<i class="fa fa-plus"></i>  Añadir Usuario
						</div>
						@endif
					</div>
				</div>
				
				<div class="card-body p-0">
						@include('livewire.users.create')
						@include('livewire.users.update')
				<div class="table-responsive">
					<table class="table table-striped table-sm">
						<thead class="thead">
							<tr> 
								<th>ID</th> 
								<th>Nombres</th>
								<th>Apellidos</th>
								<th>Tipo Doc</th>
								<th># Documento</th>
								<th>Email</th>
								<th>Avatar</th>
								<th>Rol</th>
								<th>Estado</th>
								<th>Borrado</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($users as $row)
							<tr>
								<td>{{ $row->id }}</td> 
								<td>{{ $row->nombres }}</td>
								<td>{{ $row->apellidos }}</td>
								<td>{{ $row->tipo_doc }}</td>
								<td>{{ $row->cedula }}</td>
								<td>{{ $row->email }}</td>
								<td>
									@if($row->img_user == NULL)
									<img class="img-profile rounded-circle img-thumbnail" src="{{ asset('admin-lte/dist/img/user7-128x128.jpg') }}" width="50px" alt="{{ $row->nombres }} {{ $row->apellidos }}">
									@else
									<img class="img-profile rounded-circle img-thumbnail" src="{{ asset('storage/profile-photos/'.$row->img_user) }}" width="50px" alt="{{ $row->nombres }} {{ $row->apellidos }}">
									@endif
								</td>
								<td>{{ $row->nombreRol }}</td>
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
									<button data-toggle="modal" data-target="#updateModal" class="btn btn-default btn-sm" wire:click="edit({{$row->id}})"><i class="fa fa-edit"></i></button>							 
									@endif
									@if($borrar == 1)
									<button class="btn btn-default btn-sm" onclick="confirm('Confirm Delete User id {{$row->id}}? \nDeleted Users cannot be recovered!')||event.stopImmediatePropagation()" wire:click="destroy({{$row->id}})"><i class="fa fa-trash"></i></button>
									@endif
								</td>
							@endforeach
						</tbody>
					</table>						
					{{ $users->links() }}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
