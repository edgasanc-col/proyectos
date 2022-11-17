@section('title', __('Proyectos'))
<div class="container-fluid mt-4">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div style="display: flex; justify-content: space-between; align-items: center;" class="row">
						<div class="float-left col-md-2 mb-2">
							<h4><i class="fab fa-laravel text-info"></i>
							Listado de Proyectos</h4>
						</div>
						@if (session()->has('message'))
						<div class="col-md-2 mb-2">
							<div wire:poll.4s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;"> {{ session('message') }} </div>
						</div>
						@endif
						<div class="col-md-3 mb-2">
							<input wire:model='keyWord' type="text" class="form-control" name="search" id="search" placeholder="Buscar Proyectos">
						</div>
						<div class="col-md-3 mb-2">
							@if($crear == 1)
							<div class="btn btn-sm btn-info float-right" data-toggle="modal" data-target="#createDataModal">
								<i class="fa fa-plus"></i>  Añadir Proyectos
							</div>
							@endif
						</div>
					</div>
				</div>
				
				<div class="card-body p-0">
						@include('livewire.proyectos.create')
						@include('livewire.proyectos.update')
						@include('livewire.proyectos.agregar')
						@include('livewire.proyectos.show')
				<div class="table-responsive">
					<table class="table table-striped table-sm">
						<thead class="thead">
							<tr> 
								<th>ID</th> 
								<th>Nombre proyecto</th>
								<th>Total Proyecto</th>
								<th>Fecha inicio</th>
								<th>Fecha fin</th>
								<th>Porcentaje desviación</th>
								<th>Nombre Area</th>
								<th>User Create</th>
								<th>User Update</th>
								<th>Estado</th>
								<th>Borrado</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($proyectos as $row)
							<tr>
								<td>{{ $row->id }}</td> 
								<td>{{ $row->nombreProyecto }}</td>
								<td>{{ number_format($row->valorTotalProyecto, 2, ',', '.') }}</td>
								<td>{{ $row->fechaInicio }}</td>
								<td>{{ $row->fechaFin }}</td>
								<td>{{ $row->porcentajeDesviacion }}%</td>
								<td>
									@php 
										$array = explode(',', $row->area_id);
									@endphp
									@foreach($areas as $data)
										@if(in_array($data->id, $array))
										<span class="badge badge-info text-wrap">{{$data->nombreArea}}</span>
										@endif
									@endforeach
								</td>
								<td>{{ $row->ucnombres }} {{ $row->ucnombres }} </td>
								<td>{{ $row->uunombres }} {{ $row->uunombres }}</td>
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
									<button class="btn btn-default btn-sm" onclick="confirm('Confirma borrar el registro Proyecto id {{$row->id}}? \nDeleted Proyectos cannot be recovered!')||event.stopImmediatePropagation()" wire:click="destroy({{$row->id}})"><i class="fa fa-trash"></i></button>
									@endif
								</td>
							@endforeach
						</tbody>
					</table>						
					{{ $proyectos->links() }}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
