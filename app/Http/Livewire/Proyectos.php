<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Proyecto;
use App\Models\Area;
use App\Models\Donante;
use App\Models\ProyectoPresupuesto;

class Proyectos extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $nombreProyecto, $valorTotalProyecto, $fechaInicio, $fechaFin, $porcentajeDesviacion, $area_id, $user_create, $user_update, $estado, $borrado;
	public $proyecto_presupuesto, $count, $proyecto_presupuesto_id, $proyecto;
	public $valorMonedaLocal, $valorMonedaExtranjera, $valorTRM, $donante_id, $proyecto_id;
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
		$mdl = 13;
        include('Include/permisos.php');

        if($ver == 0) {
			return view('error');
		}
        else {
			$keyWord = '%'.$this->keyWord .'%';

			$areas = Area::where('estado', 1)->where('borrado', 0)->get();
			$donantes = Donante::where('estado', 1)->where('borrado', 0)->get();

			return view('livewire.proyectos.view', [
				'proyectos' => DB::table('proyectos as pr')
							->leftJoin('users as uc', 'pr.user_create', 'uc.id')
							->leftJoin('users as uu', 'pr.user_update', 'uu.id')
							->leftJoin('areas as a', 'pr.area_id', 'a.id')
							->select('pr.*', 'a.nombreArea','uc.nombres as ucnombres', 'uc.apellidos as ucapellidos', 'uu.nombres as uunombres', 'uu.apellidos as uuapellidos')
							->orWhere('nombreProyecto', 'LIKE', $keyWord)
							->orWhere('fechaInicio', 'LIKE', $keyWord)
							->orWhere('fechaFin', 'LIKE', $keyWord)
							->orWhere('porcentajeDesviacion', 'LIKE', $keyWord)
							->orWhere('a.nombreArea', 'LIKE', $keyWord)
							->orWhere('uc.nombres', 'LIKE', $keyWord)
							->orWhere('uc.apellidos', 'LIKE', $keyWord)
							->orWhere('uu.nombres', 'LIKE', $keyWord)
							->orWhere('uu.apellidos', 'LIKE', $keyWord)
							->orderBy('pr.id', 'DESC')
							->paginate(10),
				'areas' => $areas,
				'donantes' => $donantes,
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
		$this->nombreProyecto = null;
		$this->valorTotalProyecto = null;
		$this->fechaInicio = null;
		$this->fechaFin = null;
		$this->porcentajeDesviacion = null;
		$this->area_id = null;
		$this->user_create = null;
		$this->user_update = null;
		$this->estado = null;
		$this->borrado = null;
		$this->valorMonedaLocal = null;
		$this->valorMonedaExtranjera = null;
		$this->valorTRM = null;
		$this->donante_id = null;
		$this->proyecto_id = null;
		$this->selected_id = null;
		$this->proyecto_presupuesto = null;
		$this->proyecto = null;
    }

    public function store()
    {
        $this->validate([
			'nombreProyecto' => 'required',
			'fechaInicio' => 'required',
			'fechaFin' => 'required',
			'porcentajeDesviacion' => 'required',
			'area_id' => 'required',
			//'user_create' => 'required',
			//'estado' => 'required',
			//'borrado' => 'required',
			'valorMonedaLocal.0' => 'required',
			'valorMonedaExtranjera.0' => 'required',
			'valorTRM.0' => 'required',
			'donante_id.0' => 'required',
			'valorMonedaLocal.*' => 'required',
			'valorMonedaExtranjera.*' => 'required',
			'donante_id.*' => 'required',
        ]);

		$proyecto = new Proyecto();
		$proyecto->nombreProyecto = $this-> nombreProyecto;
		$proyecto->fechaInicio = $this-> fechaInicio;
		$proyecto->fechaFin = $this-> fechaFin;
		$proyecto->porcentajeDesviacion = $this-> porcentajeDesviacion;
		$proyecto->area_id = implode(',',$this-> area_id);
		$proyecto->user_create = Auth::user()->id;
		$proyecto->user_update = null;
		$proyecto->updated_at = null;
		$proyecto->estado = 1;
		$proyecto->borrado = 0;
		$proyecto->save();

		$total = 0;

		foreach ($this->valorMonedaLocal as $key => $value) 
		{
			# code...
			ProyectoPresupuesto::create([ 
				'valorMonedaLocal' => $this->valorMonedaLocal[$key],
				'valorMonedaExtranjera' => $this->valorMonedaExtranjera[$key],
				'valorTRM' => $this->valorTRM[$key],
				'donante_id' => $this->donante_id[$key],
				'proyecto_id' => $proyecto->id,
				'user_create' => Auth::user()->id,
				'user_update' => null,
				'updated_at' => null,
				'estado' => 1,
				'borrado' => 0
			]);

			$total += $this->valorMonedaLocal[$key];
		}   
		
		$proyecto = Proyecto::find($proyecto->id);
		$proyecto->valorTotalProyecto = $total;
		$proyecto->save();
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Proyecto Successfully created.');
    }

	public function agregar($id)
	{
		$this->selected_id = $id;
		$this->agregarMode = true;
		$this->proyecto = Proyecto::find($id);
	}

	public function guardaragregar()
	{
		//guardar en la tabla proyecto_presupuestos
		$this->validate([
			'selected_id' => 'required',
			'valorMonedaLocal.0' => 'required',
			'valorMonedaExtranjera.0' => 'required',
			'valorTRM.0' => 'required',
			'donante_id.0' => 'required',
			'valorMonedaLocal.*' => 'required',
			'valorMonedaExtranjera.*' => 'required',
			'donante_id.*' => 'required',
		]);

		//Consulta valor total proyecto
		$proyecto = Proyecto::find($this->selected_id);

		$total = $proyecto->valorTotalProyecto;

		foreach ($this->valorMonedaLocal as $key => $value) 
		{
			# code...
			ProyectoPresupuesto::create([ 
				'valorMonedaLocal' => $this->valorMonedaLocal[$key],
				'valorMonedaExtranjera' => $this->valorMonedaExtranjera[$key],
				'valorTRM' => $this->valorTRM[$key],
				'donante_id' => $this->donante_id[$key],
				'proyecto_id' => $this->selected_id,
				'user_create' => Auth::user()->id,
				'user_update' => null,
				'updated_at' => null,
				'estado' => 1,
				'borrado' => 0
			]);

			$total += $this->valorMonedaLocal[$key];

			//Guardar valor total proyecto acumulado
		}
		
		$this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Descuento Successfully created.');
	}

	public function show($id)
	{
		//Datos del Proyecto
		$record = Proyecto::find($id);
		$this->nombreProyecto = $record-> nombreProyecto;
		$this->valorTotalProyecto = $record-> valorTotalProyecto;
		$this->fechaInicio = $record-> fechaInicio;
		$this->fechaFin = $record-> fechaFin;
		$this->porcentajeDesviacion = $record-> porcentajeDesviacion;
		$this->area_id = explode(',', $record-> area_id);;
		//Presupuesto Proyecto
		$this->proyecto_id = $record->id;
		$this->count = ProyectoPresupuesto::where('proyecto_id', $record->id)->where('estado', 1)->where('borrado', 0)->count();
		$this->proyecto_presupuesto = ProyectoPresupuesto::where('proyecto_id', $record->id)->where('estado', 1)->where('borrado', 0)->get();
		
		for ($i=0; $i < $this->count; $i++) { 
			# code...
			$this->proyecto_presupuesto_id[$i] = $this->proyecto_presupuesto[$i]->id;
			$this->valorMonedaLocal[$i] = $this->proyecto_presupuesto[$i]->valorMonedaLocal;
            $this->valorMonedaExtranjera[$i] = $this->proyecto_presupuesto[$i]->valorMonedaExtranjera;
			$this->valorTRM[$i] = $this->proyecto_presupuesto[$i]->valorTRM;
            $this->donante_id[$i] = $this->proyecto_presupuesto[$i]->donante_id;
		}

		$this->showMode = true;
	}
	
    public function edit($id)
    {
        $record = Proyecto::findOrFail($id);
		$agregar = ProyectoPresupuesto::where('proyecto_id', $record->id)->first();

        $this->selected_id = $id; 
		$this->nombreProyecto = $record-> nombreProyecto;
		$this->valorTotalProyecto = $record-> valorTotalProyecto;
		$this->fechaInicio = $record-> fechaInicio;
		$this->fechaFin = $record-> fechaFin;
		$this->porcentajeDesviacion = $record-> porcentajeDesviacion;
		$this->area_id = explode(',', $record-> area_id);
		$this->user_create = $record-> user_create;
		$this->user_update = $record-> user_update;
		$this->estado = $record-> estado;
		$this->borrado = $record-> borrado;

		$this->proyecto_id = $record->id;

		$this->count = ProyectoPresupuesto::where('proyecto_id', $record->id)->where('estado', 1)->where('borrado', 0)->count();
		$this->proyecto_presupuesto = ProyectoPresupuesto::where('proyecto_id', $record->id)->where('estado', 1)->where('borrado', 0)->get();

		for ($i=0; $i < $this->count; $i++) { 
			# code...
			$this->proyecto_presupuesto_id[$i] = $this->proyecto_presupuesto[$i]->id;
			$this->valorMonedaLocal[$i] = $this->proyecto_presupuesto[$i]->valorMonedaLocal;
            $this->valorMonedaExtranjera[$i] = $this->proyecto_presupuesto[$i]->valorMonedaExtranjera;
			$this->valorTRM[$i] = $this->proyecto_presupuesto[$i]->valorTRM;
            $this->donante_id[$i] = $this->proyecto_presupuesto[$i]->donante_id;
		}
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
		'nombreProyecto' => 'required',
		'fechaInicio' => 'required',
		'fechaFin' => 'required',
		'porcentajeDesviacion' => 'required',
		'area_id' => 'required',
		//'user_create' => 'required',
		'estado' => 'required',
		'borrado' => 'required',
		'selected_id' => 'required',
		'valorMonedaLocal' => 'required',
		'valorMonedaExtranjera' => 'required',
		'valorTRM' => 'required',
		'donante_id' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Proyecto::find($this->selected_id);
            $record->update([ 
			'nombreProyecto' => $this-> nombreProyecto,
			'fechaInicio' => $this-> fechaInicio,
			'fechaFin' => $this-> fechaFin,
			'porcentajeDesviacion' => $this-> porcentajeDesviacion,
			'area_id' => implode(',',$this-> area_id),
			//'user_create' => $this-> user_create,
			'user_update' => Auth::user()->id,
			'estado' => $this-> estado,
			'borrado' => $this-> borrado
            ]);

			$total = 0;

			foreach ($this->proyecto_presupuesto_id as $key => $value) 
			{
				# code...
				$presupuesto = ProyectoPresupuesto::find($this->proyecto_presupuesto_id[$key]);
				$presupuesto->update([ 
					'valorMonedaLocal' => $this->valorMonedaLocal[$key],
					'valorMonedaExtranjera' => $this->valorMonedaExtranjera[$key],
					'valorTRM' => $this->valorTRM[$key],
					'donante_id' => $this->donante_id[$key],
					'proyecto_id' => $record->id,
					'user_create' => Auth::user()->id,
					'user_update' => null,
					'updated_at' => null,
					'estado' => 1,
					'borrado' => 0
				]);

				$total += $this->valorMonedaLocal[$key];
			}

			$record->update([
				'valorTotalProyecto' => $total
			]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Proyecto Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Proyecto::where('id', $id);
            $record->update([ 
				'user_update' => Auth::user()->id,
				'borrado' => 1
			]);
			$presupuesto = ProyectoPresupuesto::where('proyecto_id', $id);
			$presupuesto->update([ 
				'user_update' => Auth::user()->id,
				'borrado' => 1
			]);
        }
    }
}
