<!-- Modal -->
<div wire:ignore.self class="modal fade" id="avanceModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="showDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showDataModalLabel">@if($actividad != null){{$actividad->nombreActividad}} <span class="badge badge-secondary">${{number_format($actividad->valorTotalActividad, '2', ',', '.')}}<span>@endif</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
           <div class="modal-body">
                <div class="table-responsive">
                    @if($avances != null)
                    <table class="table table-border table-sm">
                        <thead>
                            <th>Codigo</th>
                            <th>Rubro</th>
                            <th>Descripción</th>
                            <th>Valor Asignado</th>
                            <th>Valor Anticipo</th>
                            <th>Legalizado</th>
                            <th>Empleado</th>
                        </thead>
                        <tbody>
                            @foreach ($avances as $row)
                            <tr>
                                <td>{{$row->codigoContable}}</td>
                                <td>{{$row->nombreRubro}}</td>
                                <td>{{$row->descripcion}}</td>
                                <td>${{number_format($row->valorAsignado, '2', ',', '.')}}</td>
                                <td>${{number_format($row->valorAnticipo, '2', ',', '.')}}</td>
                                <td>
                                    @if($row->legalizado == 1)
										<span class="badge badge-success">Si</span>
									@else
										<span class="badge badge-danger">No</span>
									@endif
                                </td>
                                <td>{{$row->nombres}} {{$row->apellidos}}</td>
                            </tr>                                
                            @endforeach
                            
                        </tbody>
                    </table>
                    @else
                    Sin datos
                    @endif
                    <h5 class="modal-title">Documentos Soporte</h5>
                    @if($archivos != null)
                    <table class="table table-border table-sm">
                        <thead>
                            <th>Descripción</th>
                            <th>Observación</th>
                            <th width="150px">Archivo</th>
                        </thead>
                        <tbody>
                            
                            @foreach ($archivos as $row)
                            <tr>
                                <td>{{$row->descripcion}}</td>
                                <td>{{$row->observacion}}</td>
                                <td>
                                    <a href="{{asset('storage/archivos/'.$row->archivo)}}" class="btn btn-primary btn-sm btn-block" target="_blank">Ver Archivo</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    Sin Datos
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" wire:click.prevent="cancel()" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>