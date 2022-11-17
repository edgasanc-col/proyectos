@section('title', __('Rubros'))
<div class="container-fluid mt-4">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div style="display: flex; justify-content: space-between; align-items: center;">
						<div class="float-left">
							<h4><i class="fab fa-laravel text-info"></i>
							Listado Rubros</h4>
						</div>
						@if (session()->has('message'))
						<div wire:poll.4s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;"> {{ session('message') }} </div>
						@endif
						<div>
							<input wire:model='keyWord' type="text" class="form-control" name="search" id="search" placeholder="Buscar Rubros">
						</div>
						<div class="btn btn-sm btn-info" data-toggle="modal" data-target="#createDataModal">
						<i class="fa fa-plus"></i>  Añadir Rubro
						</div>
					</div>
				</div>
				
				<div class="card-body p-0">
						@include('livewire.rubros.create')
						@include('livewire.rubros.update')
				<div class="table-responsive">
					<table class="table table-striped table-sm">
						<thead class="thead">
							<tr> 
								<th>ID</th> 
								<th>Nombre rubro</th>
								<th>Código contable</th>
								<th>Sub Cuenta</th>
								<th>User Create</th>
								<th>User Update</th>
								<th>Estado</th>
								<th>Borrado</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($rubros as $row)
							<tr>
								<td>{{ $row->id }}</td> 
								<td>{{ $row->nombreRubro }}</td>
								<td>{{ $row->codigoContable }}</td>
								<td>{{ $row->subCuenta }}</td>
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
									<button data-toggle="modal" data-target="#updateModal" class="btn btn-default btn-sm" wire:click="edit({{$row->id}})"><i class="fa fa-edit"></i></button>							 
									<button class="btn btn-default btn-sm" onclick="confirm('Confirma borrar el registro Rubro id {{$row->id}}? \nDeleted Rubros cannot be recovered!')||event.stopImmediatePropagation()" wire:click="destroy({{$row->id}})"><i class="fa fa-trash"></i></button>
								</td>
							@endforeach
						</tbody>
					</table>						
					{{ $rubros->links() }}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
