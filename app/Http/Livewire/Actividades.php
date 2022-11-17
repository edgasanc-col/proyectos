<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Actividade;
use App\Models\Resultado;
use App\Models\Proyecto;
use App\Models\Empleado;
use App\Models\Rubro;
use App\Models\ActividadRubro;

class Actividades extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $nombreActividad, $producto, $valorTotalActividad, $valorUnitario, $cantidad, $valorTotal, $ponderacion, $fecha_ejecucion, $fecha_limite, $fecha_realizacion, $empleado_id, $proyecto_id, $resultado_id, $user_create, $user_update, $estado, $borrado, $rubro_id, $actividad_id;
    public $rubro, $actividad_rubro, $count, $actividad_rubro_id;
	public $presupuesto, $valorTotalActividades, $nombreResultado, $ponderacionResultado, $color, $presupuestoResultado, $actividades_resultado;
	public $i = 0;
	public $inputs = [];
	public $updateMode = false;
	public $agregarmode = false;
	public $showMode = false;

	public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);
    }

	public function remove($i)
    {
        unset($this->inputs[$i]);
		$this->i = $i;
    }
	
    public function render()
    {
		$mdl = 15;
        include('Include/permisos.php');

        if($ver == 0) {
			return view('error');
		}
        else {
			$keyWord = '%'.$this->keyWord .'%';

			if($this->resultado_id != null)
			{
				$resultado = Resultado::find($this->resultado_id);

				if($resultado != NULL)
				{
					$this->presupuesto = $resultado->presupuesto;

					$this->valorTotalActividades = Actividade::where('resultado_id', $this->resultado_id)->sum('valorTotalActividad');

					$total = DB::table('actividades as a')
						->leftJoin('resultados as r', 'a.resultado_id', 'r.id')
						->select('r.nombreResultado', 'r.presupuesto', DB::raw("SUM(a.ponderacion) as avance"))
						->where('r.id', $this->resultado_id)
						->groupBy('r.id')
						->first();
					
					if($total != NULL)
					{
						$this->nombreResultado = $total->nombreResultado;
						$this->ponderacionResultado = $total->avance;
						$this->presupuestoResultado = $total->presupuesto;
					}
					else
					{
						$this->nombreResultado = NULL;
						$this->ponderacionResultado = NULL;
						$this->presupuestoResultado = NULL;
					}

					if($this->ponderacionResultado < 30)
					{
						$this->color = "bg-danger";
					}
					elseif($this->ponderacionResultado > 30 && $this->ponderacionResultado < 80)
					{
						$this->color ="bg-warning";
					}
					else
					{
						$this->color ="bg-success";
					}
					//Listar las actividades asociadas al resultado
					$this->actividades_resultado = Actividade::where('resultado_id', $this->resultado_id)->get();
				}
			}

			$empleados = DB::table('empleados as e')
				->leftJoin('areas as a', 'e.area_id', 'a.id')
				->leftJoin('organizacions as o', 'a.organizacion_id', 'o.id')
				->leftJoin('users as u', 'e.user_id', 'u.id')
				->select('e.id', 'u.nombres', 'u.apellidos', 'a.nombreArea', 'o.nombreOrganizacion')
				->where('e.estado', 1)
				->where('e.borrado', 0)
				->get();

			$proyectos = Proyecto::where('borrado', 0)->get();

			if($this->proyecto_id != NULL)
			{
				$resultados = Resultado::where('proyecto_id', $this->proyecto_id)->where('estado', 1)->where('borrado', 0)->get();
			}
			elseif($this->keyWord != NULL)
			{
				$resultados = DB::table('resultados as r')
					->leftJoin('proyectos as p', 'r.proyecto_id', 'p.id')
					->select('r.*')
					->where('p.nombreProyecto', $this->keyWord)
					->where('r.estado', 1)
					->where('r.borrado', 0)
					->get();
			}
			else
			{
				$resultados = null;
			}
			
			
			if($this->rubro != NULL || $this->rubro != "")
			{
				$rubros = Rubro::where('nombreRubro', 'LIKE', '%'.$this->rubro.'%')->where('estado', 1)->where('borrado', 0)->get();
			}
			else
			{
				$rubros = Rubro::where('estado', 1)->where('borrado', 0)->get();
			}
			

			return view('livewire.actividades.view', [
				'actividades' => DB::table('actividades as ac')
							->leftJoin('users as uc', 'ac.user_create', 'uc.id')
							->leftJoin('users as uu', 'ac.user_update', 'uu.id')
							->leftJoin('empleados as e', 'ac.empleado_id', 'e.id')
							->leftJoin('users as ue', 'e.user_id', 'ue.id')
							->leftJoin('resultados as r', 'ac.resultado_id', 'r.id')
							->leftJoin('proyectos as p', 'r.proyecto_id', 'p.id')
							->select('ac.*', 'ue.nombres as uenombres', 'ue.apellidos as ueapellidos', 'r.nombreResultado', 'p.nombreProyecto','uc.nombres as ucnombres', 'uc.apellidos as ucapellidos', 'uu.nombres as uunombres', 'uu.apellidos as uuapellidos')
							->orWhere('ac.nombreActividad', 'LIKE', $keyWord)
							->orWhere('ac.valorTotalActividad', 'LIKE', $keyWord)
							->orWhere('r.nombreResultado', 'LIKE', $keyWord)
							->orWhere('p.nombreProyecto', 'LIKE', $keyWord)
							->orWhere('uc.nombres', 'LIKE', $keyWord)
							->orWhere('uc.apellidos', 'LIKE', $keyWord)
							->orWhere('uu.nombres', 'LIKE', $keyWord)
							->orWhere('uu.apellidos', 'LIKE', $keyWord)
							->orderBy('ac.id', 'DESC')
							->paginate(10),
				'empleados' => $empleados,
				'resultados' => $resultados,
				'proyectos' => $proyectos,
				'rubros' => $rubros,
				'crear' => $crear,
                'editar' => $editar,
                'borrar' => $borrar,
                'exportar' => $exportar,
                'importar' => $importar,
				'ver' => $ver
			]);
		}
    }
	
    public function cancel()
    {
        $this->resetInput();
        $this->updateMode = false;
		$this->agregarMode = false;
    }
	
    private function resetInput()
    {		
		$this->nombreActividad = null;
		$this->producto = null;
		$this->valorTotalActividad = null;
		$this->ponderacion = null;
		$this->fecha_ejecucion = null;
		$this->fecha_limite = null;
		$this->fecha_realizacion = null;
		$this->empleado_id = null;
		$this->resultado_id = null;
		$this->user_create = null;
		$this->user_update = null;
		$this->estado = null;
		$this->borrado = null;
		$this->rubro_id = null;
		$this->valorUnitario = null;
		$this->cantidad = null;
		$this->valorTotal = null;
		$this->selected_id = null;
		$this->valorUnitario = null;
		$this->cantidad = null;
		$this->rubro_id = null;
		$this->presupuesto = null;
		$this->valorTotalActividades = null;
		$this->actividades_resultado = null;
		$this->proyecto_id = null;
    }

    public function store()
    {
        $this->validate([
			'proyecto_id' => 'required',
			'nombreActividad' => 'required',
			'producto' => 'required',
			'ponderacion' => 'required',
			'fecha_ejecucion' => 'required|date',
			'fecha_limite' => 'required|date',
			'empleado_id' => 'required',
			'resultado_id' => 'required',
			//'user_create' => 'required',
			//'estado' => 'required',
			//'borrado' => 'required',
			'valorUnitario.0' => 'required',
			'valorUnitario.*' => 'required',
			'cantidad.0' => 'required',
			'cantidad.*' => 'required',
			'rubro_id.0' => 'required',
			'rubro_id.*' => 'required',
        ]);

		$actividad = new Actividade();
		$actividad->nombreActividad = $this-> nombreActividad;
		$actividad->producto = $this-> producto;
		$actividad->valorTotalActividad = 0;
		$actividad->ponderacion = $this-> ponderacion;
		$actividad->fecha_ejecucion = $this-> fecha_ejecucion;
		$actividad->fecha_limite = $this-> fecha_limite;
		$actividad->fecha_realizacion = null;
		$actividad->empleado_id = $this-> empleado_id;
		$actividad->resultado_id = $this-> resultado_id;
		$actividad->user_create = Auth::user()->id;
		$actividad->user_update = null;
		$actividad->updated_at = null;
		$actividad->estado = 1;
		$actividad->borrado = 0;
		$actividad->save();

		$total = 0;

		foreach ($this->rubro_id as $key => $value)
		{ 
			# code...
			ActividadRubro::create([ 
				'rubro_id' => $this->rubro_id[$key],
				'valorUnitario' => $this->valorUnitario[$key],
				'cantidad' => $this->cantidad[$key],
				'valorTotal' => $this->valorUnitario[$key] * $this->cantidad[$key],
				'actividad_id' => $actividad->id,
				'user_create' => Auth::user()->id,
				'user_update' => null,
				'updated_at' => null,
				'estado' => 1,
				'borrado' => 0
			]);

			$total += $this->valorUnitario[$key] * $this->cantidad[$key];
		}

		$actividad = Actividade::find($actividad->id);
		$actividad->valorTotalActividad = $total;
		$actividad->save();
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Actividade Successfully created.');
    }

	public function agregar($id)
	{
		$this->selected_id = $id;
		$this->agregarMode = true;
		$this->actividad_id = $id;
	}

	public function guardaragregar()
	{
		$this->validate([
			'selected_id' => 'required',
			'valorUnitario.0' => 'required',
			'valorUnitario.*' => 'required',
			'cantidad.0' => 'required',
			'cantidad.*' => 'required',
			'rubro_id.0' => 'required',
			'rubro_id.*' => 'required',
		]);

		//Consulta valor total Actividad
		$actividad = Actividade::find($this->selected_id);

		$total = $actividad->valorTotalActividad;
	
	foreach ($this->rubro_id as $key => $value)
		{ 
			# code...
			ActividadRubro::create([ 
				'rubro_id' => $this->rubro_id[$key],
				'valorUnitario' => $this->valorUnitario[$key],
				'cantidad' => $this->cantidad[$key],
				'valorTotal' => $this->valorUnitario[$key] * $this->cantidad[$key],
				'actividad_id' => $this->selected_id,
				'user_create' => Auth::user()->id,
				'user_update' => null,
				'updated_at' => null,
				'estado' => 1,
				'borrado' => 0
			]);

			$total += $this->valorUnitario[$key] * $this->cantidad[$key];
		}
		$this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Descuento Successfully created.');
	}

	public function show($id)
	{
		//Datos Actividad
		$record = Actividade::find($id);
		$this->nombreActividad = $record-> nombreActividad;
		$this->producto = $record-> producto;
		$this->valorTotalActividad = $record-> valorTotalActividad;
		$this->ponderacion = $record-> ponderacion;
		$this->fecha_ejecucion = $record-> fecha_ejecucion;
		$this->fecha_limite = $record-> fecha_limite;
		$this->fecha_realizacion = $record-> fecha_realizacion;
		$this->empleado_id = $record-> empleado_id;
		$this->resultado_id = $record-> resultado_id;
		//Actividad Rubro
		$this->actividad_id = $record->id;
		$this->count = ActividadRubro::where('actividad_id', $record->id)->where('estado', 1)->where('borrado', 0)->count();
		$this->actividad_rubro = ActividadRubro::where('actividad_id', $record->id)->where('estado', 1)->where('borrado', 0)->get();

		for ($i=0; $i < $this->count; $i++) { 
			# code...
			$this->actividad_rubro_id[$i] = $this->actividad_rubro[$i]->id;
			$this->rubro_id[$i] = $this->actividad_rubro[$i]->rubro_id;
			$this->valorUnitario[$i] = $this->actividad_rubro[$i]-> valorUnitario;
			$this->valorTotal[$i] = $this->actividad_rubro[$i]-> valorTotal;
			$this->cantidad[$i] = $this->actividad_rubro[$i]-> cantidad;
		}

		$this->showMode = true;

	}

    public function edit($id)
    {
        $record = Actividade::findOrFail($id);
		$agregar = ActividadRubro::where('actividad_id', $record->id)->first();

        $this->selected_id = $id; 
		$this->nombreActividad = $record-> nombreActividad;
		$this->producto = $record-> producto;
		$this->valorTotalActividad = $record-> valorTotalActividad;
		$this->ponderacion = $record-> ponderacion;
		$this->fecha_ejecucion = $record-> fecha_ejecucion;
		$this->fecha_limite = $record-> fecha_limite;
		$this->fecha_realizacion = $record-> fecha_realizacion;
		$this->empleado_id = $record-> empleado_id;
		$this->resultado_id = $record-> resultado_id;
		//Proyecto_id
		$resultado = Resultado::find($this->resultado_id);
		$this->proyecto_id = $resultado->proyecto_id;
		$this->user_create = $record-> user_create;
		$this->user_update = $record-> user_update;
		$this->estado = $record-> estado;
		$this->borrado = $record-> borrado;

		$this->actividad_id = $record->id;

		$this->count = ActividadRubro::where('actividad_id', $record->id)->where('estado', 1)->where('borrado', 0)->count();
		$this->actividad_rubro = ActividadRubro::where('actividad_id', $record->id)->where('estado', 1)->where('borrado', 0)->get();

		for ($i=0; $i < $this->count; $i++) { 
			# code...
			$this->actividad_rubro_id[$i] = $this->actividad_rubro[$i]->id;
			$this->rubro_id[$i] = $this->actividad_rubro[$i]->rubro_id;
			$this->valorUnitario[$i] = $this->actividad_rubro[$i]-> valorUnitario;
			$this->cantidad[$i] = $this->actividad_rubro[$i]-> cantidad;

		}
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
			'nombreActividad' => 'required',
			'producto' => 'required',
			'ponderacion' => 'required',
			'fecha_ejecucion' => 'required',
			'fecha_limite' => 'required',
			'fecha_realizacion' => 'required',
			'empleado_id' => 'required',
			'resultado_id' => 'required',
			'valorUnitario.*' => 'required',
			'cantidad.*' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Actividade::find($this->selected_id);
            $record->update([ 
				'nombreActividad' => $this-> nombreActividad,
				'producto' => $this->producto,
				'ponderacion' => $this-> ponderacion,
				'fecha_ejecucion' => $this-> fecha_ejecucion,
				'fecha_limite' => $this-> fecha_limite,
				'fecha_realizacion' => $this-> fecha_realizacion,
				'empleado_id' => $this-> empleado_id,
				'resultado_id' => $this-> resultado_id,
				'user_update' => Auth::user()->id,
            ]);

			$total = 0;

			foreach ($this->rubro_id as $key => $value)
			{
				#code...
				$actividad = actividadRubro::find($this->actividad_rubro_id[$key]);
				$actividad->update([
					'rubro_id' => $this->rubro_id[$key],
					'valorUnitario' => $this-> valorUnitario[$key],
					'cantidad' => $this-> cantidad[$key],
					'total' => $this-> valorUnitario[$key] * $this-> cantidad[$key],
					'actividad_id' => $record->id,
					'user_create' => Auth::user()->id,
					'user_update' => null,
					'updated_at' => null,
					'estado' => 1,
					'borrado' => 0
				]);

				$total += $this->valorUnitario[$key] * $this->cantidad[$key];
			}

			$record->update([
				'valorTotalActividad' => $total
			]);


            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Actividade Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Actividade::where('id', $id);
            $record->delete([ 
				'user_update' => Auth::user()->id,
				'borrado' => 1
			]);
			$actividad = ActividadRubro::where('resultado_id', $id);
			$actividad->update([
				'user_update' => Auth::user()->id,
				'borrado' => 1
			]);
        }
    }
}
