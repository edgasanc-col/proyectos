@section('title', __('Avances'))
<div class="container-fluid mt-4">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div style="display: flex; justify-content: space-between; align-items: center;"class="row">
						<div class="float-left">
							<h4><i class="fab fa-laravel text-info"></i>
							Avance</h4>
						</div>
						@if (session()->has('message'))
						<div class="col-md-2 mb-2">
							<div wire:poll.4s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;">
								{{ session('message') }}
							</div>
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
								@foreach ($resultados as $row)
								<option value="{{$row->nombreResultado}}">{{$row->nombreResultado}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-2 mb-2">
							<select wire:model="keyWord" id="keyWord" class="form-control">
								<option value="">-Filtrar por Actividad-</option>
								@foreach ($actividades as $row)
								<option value="{{$row->nombreActividad}}">{{$row->nombreActividad}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-2 mb-2">
							<input wire:model='keyWord' type="text" class="form-control" name="search" id="search" placeholder="Buscar Avances">
						</div>
						<div class="col-md-2 mb-2">
							@if($crear == 1)
							<div class="btn btn-sm btn-info" data-toggle="modal" data-target="#createDataModal">
								<i class="fa fa-plus"></i>  Añadir Avances
							</div>
							@endif
						</div>
					</div>
				</div>
				
				<div class="card-body p-0">
						@include('livewire.avances.create')
						@include('livewire.avances.update')
						@include('livewire.avances.file')
				<div class="table-responsive">
					<table class="table table-striped table-sm">
						<thead class="thead">
							<tr> 
								<th>#</th> 
								<th>Rubro</th>
								<th>Descripcion</th>
								<th>Valor Asignado</th>
								<th>Valor Anticipo</th>
								<th>Legalizado</th>
								<th>Empleado</th>
								<th>Actividad</th>
								<th>Resultado</th>
								<th>Proyecto</th>
								<th>Estado</th>
								<th>Borrado</th>
								<th width="140px">Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($avances as $row)
							<tr>
								<td>{{ $row->id }}</td> 
								<td>{{ $row->nombreRubro }}</td>
								<td>{{ $row->descripcion }}</td>
								<td>${{ number_format($row->valorAsignado, '2', ',', '.') }}</td>
								<td>${{ number_format($row->valorAnticipo, '2', ',', '.') }}</td>
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
								<td>{{ $row->nombres }} {{ $row->apellidos }}</td>
								<td>{{ $row->nombreActividad }}</td>
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
								<td>
									@if($editar == 1)
									<button data-toggle="modal" data-target="#updateModal" class="btn btn-default btn-sm" wire:click="edit({{$row->id}})"><i class="fa fa-edit"></i></button>
									@endif
									@if($crear == 1)
									<button data-toggle="modal" data-target="#fileModal" class="btn btn-default btn-sm" wire:click="file({{$row->id}})"><i class="fa fa-folder"></i></button>
									@endif
									@if($borrar == 1)
									<button class="btn btn-default btn-sm" onclick="confirm('Confirma borrar el registro Avance id {{$row->id}}? \nDeleted Avances cannot be recovered!')||event.stopImmediatePropagation()" wire:click="destroy({{$row->id}})"><i class="fa fa-trash"></i></button>
									@endif
								</td>
							@endforeach
						</tbody>
					</table>						
					{{ $avances->links() }}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
