<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Empleado;
use App\Models\Rubro;
use App\Models\Donante;
use App\Models\Proyecto;
use App\Models\ProyectoPresupuesto;
use App\Models\Resultado;
use App\Models\ResultadoUser;
use App\Models\Actividade;
use App\Models\ActividadRubro;
use App\Models\Avance;
use App\Models\Archivo;

class Dashboard extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';

    public $proyecto_id, $actividad, $avances, $archivos;
    public $showMode = false;

    public function render()
    {
        $proyectos = Proyecto::where('borrado', 0)->orderBy('id', 'DESC')->get();

        $proyectos_resultados = DB::table('resultados as r')
            ->leftJoin('proyectos as p', 'r.proyecto_id', 'p.id')
            ->select('p.id', 'p.nombreProyecto', 'p.porcentajeDesviacion', 'p.valorTotalProyecto', DB::raw("SUM(r.ponderacion) AS avance"), DB::raw("SUM(r.presupuesto) AS comprometido"))
            ->where('p.borrado', 0)
            ->groupBy('r.proyecto_id')
            ->orderBy('p.id', 'DESC')
            ->get();
        
        $proyectos_actividades = DB::table('actividades as a')
            ->leftJoin('resultados as r', 'a.resultado_id', 'r.id')
            ->leftJoin('proyectos as p', 'r.proyecto_id', 'p.id')
            ->select('p.id', 'r.nombreResultado', DB::raw("SUM(a.valorTotalActividad) AS ejecutado"), DB::raw("SUM(a.ponderacion) AS avance"))
            ->where('p.borrado', 0)
            ->groupBy('a.resultado_id')
            ->get();
        
        if (isset($this->proyecto_id) && $this->proyecto_id != NULL) {
            # Resultados del Proyecto ID
            $proyecto = DB::table('proyectos as p')
                ->leftJoin('areas as a', 'p.area_id', 'a.id')
                ->leftJoin('organizacions as o', 'a.organizacion_id', 'o.id')
                ->select('p.*', 'a.nombreArea', 'o.nombreOrganizacion')
                ->where('p.id', $this->proyecto_id)
                ->first();
            $presupuesto = DB::table('proyecto_presupuestos as pp')
                ->leftJoin('donantes as d', 'pp.donante_id', 'd.id')
                ->select('pp.*', 'd.nombreDonante')
                ->where('pp.proyecto_id', $this->proyecto_id)
                ->get();
            $resultados = DB::table('resultados as r')
                ->select('r.*')
                ->where('r.proyecto_id', $this->proyecto_id)
                ->orderBy('r.id', 'ASC')
                ->get();
            # Responsables del Resultado ID
            $responsables_resultado = DB::table('resultado_users as ru')
                ->leftJoin('resultados as r', 'ru.resultado_id', 'r.id')
                ->leftJoin('proyectos as p', 'r.proyecto_id', 'p.id')
                ->leftJoin('empleados as e', 'ru.empleado_id', 'e.id')
                ->leftJoin('users as u', 'e.user_id', 'u.id')
                ->select('ru.*', 'u.nombres', 'u.apellidos')
                ->where('p.id', $this->proyecto_id)
                ->where('ru.borrado', 0)
                ->get();
            #TOTAL
            $valorComprometido = 0;
            foreach ($resultados as $row) {
                $valorComprometido += $row->presupuesto;
            }
            # Actividades del Resultado ID > Proyecto ID
            $actividades = DB::table('actividades as a')
                ->leftJoin('resultados as r', 'a.resultado_id', 'r.id')
                ->leftJoin('proyectos as p', 'r.proyecto_id', 'p.id')
                ->leftJoin('empleados as e', 'a.empleado_id', 'e.id')
                ->leftJoin('users as u', 'e.user_id', 'u.id')
                ->select('a.*', 'u.nombres', 'u.apellidos')
                ->where('p.id', $this->proyecto_id)
                ->where('a.borrado', 0)
                ->get();
            # Rubros por Actividades ID > Resultado ID > Proyecto ID
            $actividades_rubro = DB::table('actividad_rubros as ar')
                ->leftJoin('actividades as a', 'ar.actividad_id', 'a.id')
                ->leftJoin('rubros as ru', 'ar.rubro_id', 'ru.id')
                ->leftJoin('resultados as r', 'a.resultado_id', 'r.id')
                ->leftJoin('proyectos as p', 'r.proyecto_id', 'p.id')
                ->leftJoin('empleados as e', 'a.empleado_id', 'e.id')
                ->leftJoin('users as u', 'e.user_id', 'u.id')
                ->select('ru.nombreRubro', 'ru.codigoContable', 'ar.valorUnitario', 'ar.cantidad', 'ar.valorTotal', 'ar.actividad_id')
                ->where('p.id', $this->proyecto_id)
                ->where('a.borrado', 0)
                ->get();
        }
        else
        {
            $proyecto = NULL;
            $presupuesto = NULL;
            $resultados = NULL;
            $valorComprometido = NULL;
            $responsables_resultado = NULL;
            $actividades = NULL;
            $actividades_rubro = NULL;
        }

        /***************************************************************************************
         * Control de Actividades
         **************************************************************************************/
        if($this->proyecto_id == null)
        {
            $control_actividades = DB::table('actividades as a')
            ->leftJoin('resultados as r', 'a.resultado_id', 'r.id')
            ->leftJoin('proyectos as p', 'r.proyecto_id', 'p.id')
            ->select('a.nombreActividad', 'a.fecha_ejecucion', 'a.fecha_limite', 'a.fecha_realizacion', 'r.nombreResultado', 'p.nombreProyecto')
            ->orderBy('a.fecha_ejecucion', 'ASC')
            ->get();
        }
        else
        {
            $control_actividades = DB::table('actividades as a')
            ->leftJoin('resultados as r', 'a.resultado_id', 'r.id')
            ->leftJoin('proyectos as p', 'r.proyecto_id', 'p.id')
            ->select('a.nombreActividad', 'a.fecha_ejecucion', 'a.fecha_limite', 'a.fecha_realizacion', 'r.nombreResultado', 'p.nombreProyecto')
            ->where('p.id', $this->proyecto_id)
            ->orderBy('a.fecha_ejecucion', 'ASC')
            ->get();
        }
        

        return view('livewire.dashboard', [
            'proyectos' => $proyectos,
            'proyectos_resultados' => $proyectos_resultados,
            'proyectos_actividades' => $proyectos_actividades,
            'proyecto' => $proyecto,
            'presupuesto' => $presupuesto,
            'resultados' => $resultados,
            'valorComprometido' => $valorComprometido,
            'responsables_resultado' => $responsables_resultado,
            'actividades' => $actividades,
            'actividades_rubro' => $actividades_rubro,
            'control_actividades' => $control_actividades,
        ]);
    }

    public function cancel()
    {
        $this->resetInput();
        $this->showMode = false;
    }

    private function resetInput()
    {	
        $this->actividad = null; 	
		$this->avances = null;
        $this->archivos = null;
    }

    public function avance($id)
    {
        $actividad = Actividade::find($id);

        $avances = DB::table('avances as av')
            ->leftJoin('rubros as r', 'av.rubro_id', 'r.id')
            ->leftJoin('empleados as e', 'av.empleado_id', 'e.id')
            ->leftJoin('users as u', 'e.user_id', 'u.id')
            ->select('av.*', 'r.nombreRubro', 'r.codigoContable', 'u.nombres', 'u.apellidos')
            ->where('av.actividad_id', $id)
            ->where('av.estado', 1)
            ->where('av.borrado', 0)
            ->get();
        $archivos = DB::table('archivos as ar')
            ->leftJoin('avances as av', 'ar.avance_id', 'av.id')
            ->leftJoin('actividades as ac', 'av.actividad_id', 'ac.id')
            ->select('ar.*', 'av.descripcion')
            ->where('ac.id', $id)
            ->get();
        
        $this->actividad = $actividad;    
        $this->avances = $avances;
        $this->archivos = $archivos;
        $this->showMode = true;
    }
}
