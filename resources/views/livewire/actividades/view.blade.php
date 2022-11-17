@section('title', __('Actividades'))
<div class="container-fluid mt-4">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div style="display: flex; justify-content: space-between; align-items: center;" class="row">
						<div class="float-left col-md-2 mb-2">
							<h4><i class="fab fa-laravel text-info"></i>
							Listado Actividades</h4>
						</div>
						@if (session()->has('message'))
						<div class="col-md-2 mb-2">
							<div wire:poll.4s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;"> {{ session('message') }} </div>
						</div>
						@endif
						<div class="col-md-2 mb-2">
							<select wire:model="keyWord" id="keyWord" class="form-control">
								<option value="">-Filtrar por Proyecto-</option>
								@foreach ($proyectos as $row)
								<option value="{{$row->nombreProyecto}}">{{$row->nombreProyecto}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-2 mb-2">
							<select wire:model="keyWord" id="keyWord" class="form-control">
								<option value="">-Filtrar por Resultado-</option>
								@if($keyWord != NULL)
								@foreach ($resultados as $row)
								<option value="{{$row->nombreResultado}}">{{$row->nombreResultado}}</option>
								@endforeach
								@endif
							</select>
						</div>
						<div class="col-md-2 mb-2">
							<input wire:model='keyWord' type="text" class="form-control" name="search" id="search" placeholder="Buscar Actividades">
						</div>
						<div class="col-md-2 mb-2">
							@if($crear == 1)
							<div class="btn btn-sm btn-info float-right" data-toggle="modal" data-target="#createDataModal">
								<i class="fa fa-plus"></i>  Añadir Actividades
							</div>
							@endif
						</div>
					</div>
				</div>
				
				<div class="card-body p-0">
						@include('livewire.actividades.create')
						@include('livewire.actividades.update')
						@include('livewire.actividades.agregar')
						@include('livewire.actividades.show')
				<div class="table-responsive">
					<table class="table table-striped table-sm">
						<thead class="thead">
							<tr> 
								<th>ID</th> 
								<th>Nombre Actividad</th>
								<th>Valor Total</th>
								<th>Ponderación</th>
								<th>Empleado</th>
								<th>Resultado</th>
								<th>Proyecto</th>
								<th>Estado</th>
								<th>Borrado</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($actividades as $row)
							<tr>
								<td>{{ $row->id }}</td> 
								<td>{{ $row->nombreActividad }}</td>
								<td width="150px">$ {{ number_format($row->valorTotalActividad, 2, ',', '.') }}</td>
								<td>{{ $row->ponderacion }}%</td>
								<td>{{ $row->uenombres }} {{ $row->ueapellidos }}</td>
								<td>{{ $row->nombreResultado }}</td>
								<td>{{ $row->nombreProyecto }}</td>
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
								<td width="180px">
									@if($editar == 1)
									<button data-toggle="modal" data-target="#updateModal" class="btn btn-default btn-sm" wire:click="edit({{$row->id}})"><i class="fa fa-edit"></i></button>							 
									@endif
									@if($crear == 1)
									<button data-toggle="modal" data-target="#agregarModal" class="btn btn-default btn-sm" wire:click="agregar({{$row->id}})"><i class="fa fa-plus"></i> </button>
									@endif
									@if($ver == 1)
									<button data-toggle="modal" data-target="#showModal" class="btn btn-default btn-sm" wire:click="show({{$row->id}})"><i class="fa fa-eye"></i> </button>					 
									@endif
									@if($borrar == 1)
									<button class="btn btn-default btn-sm" onclick="confirm('Confirma borrar el registro Actividade id {{$row->id}}? \nDeleted Actividades cannot be recovered!')||event.stopImmediatePropagation()" wire:click="destroy({{$row->id}})"><i class="fa fa-trash"></i></button>
									@endif
								</td>
							@endforeach
						</tbody>
					</table>						
					{{ $actividades->links() }}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
