<div class="container-fluid ">
    <!-- Seccion Resumen Proyectos -->
    <div class="row">
        @foreach ($proyectos_resultados as $item)
        <div class="col-lg-4 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3><span class="badge badge-primary">${{number_format($item->valorTotalProyecto, 2, ',', '.')}}</span></h3>
                    <h4>{{$item->nombreProyecto}}</h4>
                    <h6>Porcentaje Desviacion: <span class="badge badge-info">{{$item->porcentajeDesviacion}}%</span></h6>
                    <div class="row">
                        <div class="col-lg-4">
                            <h4><span class="badge badge-warning">${{number_format($item->comprometido, 2, ',', '.')}}</span></h4>
                            <p>Valor Aprobado</p>
                        </div>
                        @foreach($proyectos_actividades as $row)
                        @if($item->id == $row->id)
                        @php $ejecutado = $row->ejecutado @endphp
                        @endif
                        @endforeach
                        <div class="col-lg-4">
                            <h4><span class="badge badge-success">${{number_format(($ejecutado), 2, ',', '.')}}</span></h4>
                            <p>Ejecutado</p>
                        </div>
                        <div class="col-lg-4">
                            <h4><span class="badge badge-danger">${{number_format($item->valorTotalProyecto-$item->comprometido, 2, ',', '.')}}</span></h4>
                            <p>Por Ejecutar</p>
                        </div>
                    </div>
                    <div class="progress mb-2">
                        <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{$item->avance}}%" aria-valuenow="{{$item->avance}}" aria-valuemin="0" aria-valuemax="100">
                            {{$item->avance}} %
                        </div>
                    </div>
                    <p><b>Avance de Proyecto</b></p>
                    <hr>
                    @foreach($proyectos_actividades as $row)
                    @if($item->id == $row->id)
                    <div class="progress mb-2">
                        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{$row->avance}}%" aria-valuenow="{{$item->avance}}" aria-valuemin="0" aria-valuemax="100">
                            {{$row->avance}} %
                        </div>
                    </div>
                    <p><b>Avance de ejecución:</b> {{$row->nombreResultado}}</p>
                    @endif
                    @endforeach
                </div>
                <div class="icon">
                    <i class="fas fa-project-diagram"></i>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <!-- Seccion Seguimiento Actividades -->
    <div class="row">
        @foreach($control_actividades as $row)
        <div class="col-md-3">
            @if($row->fecha_limite < date('Y-m-d')) 
                @php 
                    $color="bg-danger";
                    $badge = "badge-warning";
                @endphp
            @elseif($row->fecha_realizacion == null)
                @php
                    $color="bg-warning";
                    $badge = "badge-danger";
                @endphp
            @else
                @php
                    $color="bg-success";
                    $badge = "badge-danger";
                @endphp 
            @endif
            <div class="card {{$color}}">
                <div class="card-header">
                    <b>{{$row->nombreActividad}}</b>
                </div>
                <div class="card-body">
                    @if($row->fecha_realizacion == null)
                    <div class="row">
                        <div class="col-md-8"><i>Fecha Ejecución:</i></div>
                        <div class="col-md-4"><span class="badge badge-secondary">{{$row->fecha_ejecucion}}</span></div>
                    </div>
                    <div class="row">
                        <div class="col-md-8"><i>Fecha Limite:</i></div>
                        <div class="col-md-4"><span class="badge {{$badge}}">{{$row->fecha_limite}}</span></div>
                    </div>
                    @else
                    <div class="row">
                        <div class="col-md-8"><i>Fecha Realización:</i></div>
                        <div class="col-md-4"><span class="badge badge-dark">{{$row->fecha_realizacion}}</span></div>
                    </div>
                    @endif
                </div>
                <div class="card-footer">
                    <span class="badge badge-light">{{$row->nombreProyecto}}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <!-- Seccion Detalle Proyectos -->
    <div class="row">
        <div class="col-md-12" wire:ignore>
            <label for="proyecto_id">Seleccione un proyecto</label>
            <select wire:model="proyecto_id" id="proyecto_id" class="form-control select2">
                <option value="">-Seleccione una opción-</option>
                @foreach ($proyectos as $row)
                <option value="{{$row->id}}">{{$row->nombreProyecto}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @include('livewire.avances')
    <div class="row mt-4">
        <!-- Detalle Proyecto -->
        <div class="col-md-12">
            @if(isset($proyecto_id) && $proyecto_id != NULL)
            <div class="card">
                <div class="card-header bg-primary">
                    <h3>Proyecto: {{$proyecto->nombreProyecto}}</h3>
                </div>
                <!-- card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <h6>Fecha Inicio</h6>
                            <h4><span class="badge badge-primary">{{$proyecto->fechaInicio}}</span></h4>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3">
                            <h6>Fecha Fin</h6>
                            <h4><span class="badge badge-primary">{{$proyecto->fechaFin}}</span></h4>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3">
                            <h6>Porcentaje Desviación</h6>
                            <h4><span class="badge badge-primary">{{$proyecto->porcentajeDesviacion}}%</span></h4>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3">
                            <h6>Organización / Área</h6>
                            <h4><span class="badge badge-primary">{{$proyecto->nombreOrganizacion}}</span> / <span class="badge badge-primary">{{$proyecto->nombreArea}}</span></h4>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /. row -->
                    <div class="row">
                        <div class="col-md-3">
                            Valor Aprobado:
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3">
                            Ejecutado:
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3">
                            Recursos por ejecutar:
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /. row -->
                    <div class="row">
                        <div class="col-md-3">
                            <h4><span class="badge badge-primary">${{number_format($proyecto->valorTotalProyecto, 2, ',', '.')}}</span></h4>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3">
                            <h4><span class="badge badge-warning">${{number_format($valorComprometido, 2, ',', '.')}}</span></h4>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3">
                            <h4><span class="badge badge-danger">${{number_format(($proyecto->valorTotalProyecto-$valorComprometido), 2, ',', '.')}}</span></h4>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /. row -->
                </div>
                <!-- card-body -->
                <div class="card-body">
                    <h4>Fuentes de Financiación</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>Valor Moneda Local</h5>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <h5>Valor Moneda Extranjera</h5>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <h5>Donante</h5>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- FUENTES DE FINANCIACIÓN -->
                    @foreach ($presupuesto as $row)
                    <div class="row">
                        <div class="col-md-4">
                            <h5><span class="badge badge-info">$ {{number_format($row->valorMonedaLocal, 2, ',', '.')}}</span></h5>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <h5><span class="badge badge-info">$ {{number_format($row->valorMonedaExtranjera, 2, ',', '.')}}</span></h5>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <h5><span class="badge badge-info">{{$row->nombreDonante}}</span></h5>
                        </div>
                        <!-- /.col -->
                    </div>
                    @endforeach
                </div>
                <!-- card-body -->
                <div class="card-body">
                    <h4>Resultados</h4>
                    <div class="row bg-dark">
                        <div class="col-md-3">
                            <h5>Nombre Resultado</h5>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3">
                            <h5>Nombre Indicador</h5>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3">
                            <h5>Presupuesto</h5>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3">
                            <h5>Responsables</h5>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- RESULTADOS DEL PROYECTO -->
                    @foreach ($resultados as $row)
                    <div class="row bg-secondary">
                        <div class="col-md-3 font-weight-bold">
                            {{$row->nombreResultado}}
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3 font-weight-bold">
                            {{$row->nombreIndicador}}
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3 font-weight-bold">
                            <b>$ {{number_format($row->presupuesto, 2, ',', '.')}}</b>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3 font-weight-bold">
                            <!-- RESPONSABLES DE LOS RESULTADOS -->
                            @foreach ($responsables_resultado as $rs)
                                @if ($row->id == $rs->resultado_id)
                            {{$rs->nombres}} {{$rs->apellidos}}<br>
                                @endif
                            @endforeach
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                    <div class="row bg-light">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3 border-bottom">
                                    <b>Nombre Actividad</b>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-2 border-bottom">
                                    <b>Producto de la actividad</b>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-1 border-bottom">
                                    <b>Ponderación</b>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-3 border-bottom">
                                    <b>Valor Actividad</b>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-2 border-bottom">
                                    <b>Responsables</b>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-1 border-bottom">
                                    <b>Detalle</b>
                                </div>
                            </div>
                            <!-- /.row -->
                            @php
                                $totalPonderacion = 0;
                                $pendienteActividad = 0;
                            @endphp
                            <!-- ACTIVIDAES DEL RESULTADO -->
                            @foreach ($actividades as $act)
                                @if ($row->id == $act->resultado_id)
                            <div class="row">
                                <div class="col-md-3 border-top border-dark">
                                    {{$act->nombreActividad}}
                                </div>
                                <!-- /.col -->
                                <div class="col-md-2 border-top border-dark">
                                    {{$act->producto}}
                                </div>
                                <!-- /.col -->
                                <div class="col-md-1 border-top border-dark">
                                    {{$act->ponderacion}}%
                                </div>
                                <!-- /.col -->
                                <div class="col-md-3 border-top border-dark">
                                    $ {{number_format($act->valorTotalActividad, 2, ',', '.')}}
                                </div>
                                <!-- /.col -->
                                <div class="col-md-2 border-top border-dark">
                                    {{$act->nombres}} {{$act->apellidos}}
                                </div>
                                <!-- /.col -->
                                <div class="col-md-1 border-top border-dark">
                                    <button data-toggle="modal" data-target="#avanceModal" class="btn btn-primary btn-sm m-2" wire:click="avance({{$act->id}})"><i class="fa fa-eye"></i> </button>
                                </div>
                            </div>
                            <!-- /.row -->
                                    @php 
                                        $totalPonderacion += $act->ponderacion;
                                        $pendienteActividad += $act->valorTotalActividad;    
                                    @endphp
                            <div class="row bg-white">
                                <div class="col-md-3 border-bottom">
                                    <b class="text-black-50">Rubro</b>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-2 border-bottom">
                                    <b class="text-black-50">Valor Unitario</b>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-1 border-bottom">
                                    <b class="text-black-50">Cantidad</b>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-3 border-bottom">
                                    <b class="text-black-50">Total</b>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-3 border-bottom">
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- DETALLE RUBRO DE LAS ACTIVIDADES -->
                                    @foreach($actividades_rubro as $actru)
                                        @if($act->id == $actru->actividad_id)
                            <div class="row bg-white">
                                <div class="col-md-3 border-bottom text-black-50">
                                    {{$actru->codigoContable}} - {{$actru->nombreRubro}}
                                </div>
                                <!-- /.col -->
                                <div class="col-md-2 border-bottom text-black-50">
                                    $ {{number_format($actru->valorUnitario, 2, ',', '.')}}
                                </div>
                                <!-- /.col -->
                                <div class="col-md-1 border-bottom text-black-50">
                                    {{$actru->cantidad}}
                                </div>
                                <!-- /.col -->
                                <div class="col-md-3 border-bottom text-black-50">
                                    $ {{number_format($actru->valorTotal, 2, ',', '.')}}
                                </div>
                                <!-- /.col -->
                                <div class="col-md-3 border-bottom">
                                </div>
                                <!-- /.col -->
                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                        <!-- /.col -->
                        <div class="col-md-5 border-top border-dark">
                            <b class="text-danger">Recursos por ejecutar</b>
                        </div>
                        <div class="col-md-1 border-top border-dark">
                            <span class="badge badge-danger">{{100-$totalPonderacion}}%</span>
                        </div>
                        <div class="col-md-3 border-top border-dark">
                            <span class="badge badge-danger">$ {{number_format($row->presupuesto-$pendienteActividad, 2, ',', '.')}}</span>
                        </div>
                        <div class="col-md-3 border-top border-dark">
                        </div>
                        @if($totalPonderacion > 0)
                        <div class="col-md-12 border-top border-dark">
                            <b>Avance del Resultado</b>
                            <div class="progress mb-2">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{$totalPonderacion}}%" aria-valuenow="{{$totalPonderacion}}" aria-valuemin="0" aria-valuemax="100">
                                    {{$totalPonderacion}} %
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                        @endif
                    </div>
                    <!-- /.row -->
                    <br>
                    @endforeach
                </div>
                <!-- card-body -->
            </div>
            <!-- /.card -->
            @endif
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>

@push('styles')
<style>
    @media print {
        .noPrint {
            display:none;
        }
    }
</style>

 <!-- Select2 -->
 <link rel="stylesheet" href="{{asset('admin-lte/plugins/select2/css/select2.min.css')}}">
 <link rel="stylesheet" href="{{asset('admin-lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endpush

@push('scripts')
<!-- Select2 -->
<script src="{{asset('admin-lte/plugins/select2/js/select2.full.min.js')}}"></script>

<script>
    document.addEventListener('livewire:load', function(){
        $('.select2').select2({
            theme: 'bootstrap4'
        });  
        $('.select2').on('change', function(){
            @this.set('proyecto_id', this.value);
        });
    })
</script>
@endpush