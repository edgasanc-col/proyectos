<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Resultado;
use App\Models\Proyecto;
use App\Models\Empleado;
use App\Models\ResultadoUser;

class Resultados extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $nombreResultado, $nombreIndicador, $presupuesto, $ponderacion, $proyecto_id, $user_create, $user_update, $estado, $borrado, $empleado_id;
    public $resultado_user, $count, $resultado_user_id;
	public $valorTotalProyecto, $valorComprometido, $resultados_proyecto;
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
		$mdl = 14;
        include('Include/permisos.php');

        if($ver == 0) {
			return view('error');
		}
        else {
			$keyWord = '%'.$this->keyWord .'%';

			//$empleados = Empleado::where('estado', 1)->where('borrado', 0)->get();
			$empleados = DB::table('empleados as e')
				->leftJoin('areas as a', 'e.area_id', 'a.id')
				->leftJoin('organizacions as o', 'a.organizacion_id', 'o.id')
				->leftJoin('users as u', 'e.user_id', 'u.id')
				->select('e.id', 'u.nombres', 'u.apellidos', 'a.nombreArea', 'o.nombreOrganizacion')
				->where('e.estado', 1)
				->where('e.borrado', 0)
				->get();
			$proyectos = Proyecto::where('estado', 1)->where('borrado', 0)->get();

			if($this->proyecto_id != null)
			{
				$proyecto = Proyecto::find($this->proyecto_id);
				if($proyecto != null)
				{
					$this->valorTotalProyecto = $proyecto->valorTotalProyecto;
					$this->valorComprometido = Resultado::where('proyecto_id', $this->proyecto_id)->sum('presupuesto');
					$this->resultados_proyecto = Resultado::where('proyecto_id', $this->proyecto_id)->get();
				}
			}

			return view('livewire.resultados.view', [
				'resultados' => DB::table('resultados as r')
							->leftJoin('users as uc', 'r.user_create', 'uc.id')
							->leftJoin('users as uu', 'r.user_update', 'uu.id')
							->leftJoin('proyectos as pr', 'r.proyecto_id', 'pr.id')
							->select('r.*', 'pr.nombreProyecto','uc.nombres as ucnombres', 'uc.apellidos as ucapellidos', 'uu.nombres as uunombres', 'uu.apellidos as uuapellidos')
							->orWhere('r.nombreResultado', 'LIKE', $keyWord)
							->orWhere('r.nombreIndicador', 'LIKE', $keyWord)
							->orWhere('pr.nombreProyecto', 'LIKE', $keyWord)
							->orWhere('uc.nombres', 'LIKE', $keyWord)
							->orWhere('uc.apellidos', 'LIKE', $keyWord)
							->orWhere('uu.nombres', 'LIKE', $keyWord)
							->orWhere('uu.apellidos', 'LIKE', $keyWord)
							->orderBy('r.id', 'DESC')
							->paginate(10),
				'proyectos' =>$proyectos,
				'empleados' => $empleados,
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
		$this->nombreResultado = null;
		$this->nombreIndicador = null;
		$this->presupuesto = null;
		$this->ponderacion = null;
		$this->proyecto_id = null;
		$this->user_create = null;
		$this->user_update = null;
		$this->estado = null;
		$this->borrado = null;
		$this->empleado_id = null;
		$this->selected_id = null;
		$this->resultado_user = null;
		$this->valorTotalProyecto = null;
		$this->valorComprometido = null;
    }

    public function store()
    {
        $this->validate([
			'nombreResultado' => 'required',
			'nombreIndicador' => 'required',
			'presupuesto' => 'required|numeric',
			'ponderacion' => 'required|numeric',
			'proyecto_id' => 'required',
			//'user_create' => 'required',
			//'estado' => 'required',
			//'borrado' => 'required',
			'empleado_id.0' => 'required',
			'empleado_id.*' => 'required',
        ]);
	
		$resultado = new Resultado();
		$resultado->nombreResultado = $this->nombreResultado;
		$resultado->nombreIndicador = $this->nombreIndicador;
		$resultado->presupuesto = $this->presupuesto;
		$resultado->ponderacion = $this->ponderacion;
		$resultado->proyecto_id = $this->proyecto_id;
		$resultado->user_create = Auth::user()->id;
		$resultado->user_update = null;
		$resultado->updated_at = null;
		$resultado->estado = 1;
		$resultado->borrado = 0;
		$resultado->save();

		foreach ($this->empleado_id as $key => $value)
		{
			#code...
			ResultadoUser::create([ 
				'empleado_id' => $this->empleado_id[$key],
				'resultado_id' => $resultado->id,
				'user_create' => Auth::user()->id,
				'user_update' => null,
				'updated_at' => null,
				'estado' => 1,
				'borrado' => 0
			]);
		}
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Resultado Successfully created.');
    }

	public function agregar($id)
	{
		$this->selected_id = $id;
		$this->agregarMode = true;
	}

	public function guardaragregar()
	{
		//guardar en la tabla resultado_users
		$this->validate([
			'selected_id' => 'required',
			'empleado_id.0' => 'required',
			'empleado_id.*' => 'required',
		]);

		foreach ($this->empleado_id as $key => $value)
		{
			#code...
			ResultadoUser::create([ 
				'empleado_id' => $this->empleado_id[$key],
				'resultado_id' => $this->selected_id,
				'user_create' => Auth::user()->id,
				'user_update' => null,
				'updated_at' => null,
				'estado' => 1,
				'borrado' => 0
			]);
		}

		$this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Descuento Successfully created.');
	}

	public function show($id)
	{
		//Datos Resultados
		$record = Resultado::find($id);
		$this->nombreResultado = $record-> nombreResultado;
		$this->nombreIndicador = $record-> nombreIndicador;
		$this->presupuesto = $record-> presupuesto;
		$this->ponderacion = $record-> ponderacion;
		$this->proyecto_id = $record-> proyecto_id;
		//Resultado Users
		$this->resultado_id = $record->id;
		$this->count = ResultadoUser::where('resultado_id', $record->id)->where('estado', 1)->where('borrado', 0)->count();
		$this->resultado_user = ResultadoUser::where('resultado_id', $record->id)->where('estado', 1)->where('borrado', 0)->get();
        
		for ($i=0; $i < $this->count; $i++){
			# code...
			$this->resultado_user_id[$i] = $this->resultado_user[$i]->id;
			$this->empleado_id[$i] = $this->resultado_user[$i]->empleado_id;
		}

	}

    public function edit($id)
    {
        $record = Resultado::findOrFail($id);
		$agregar = ResultadoUser::where('resultado_id', $record->id)->first();

        $this->selected_id = $id; 
		$this->nombreResultado = $record-> nombreResultado;
		$this->nombreIndicador = $record-> nombreIndicador;
		$this->presupuesto = $record-> presupuesto;
		$this->ponderacion = $record-> ponderacion;
		$this->proyecto_id = $record-> proyecto_id;
		$this->user_create = $record-> user_create;
		$this->user_update = $record-> user_update;
		$this->estado = $record-> estado;
		$this->borrado = $record-> borrado;

		$this->resultado_id = $record->id;

		$this->count = ResultadoUser::where('resultado_id', $record->id)->where('estado', 1)->where('borrado', 0)->count();
		$this->resultado_user = ResultadoUser::where('resultado_id', $record->id)->where('estado', 1)->where('borrado', 0)->get();
        
		for ($i=0; $i < $this->count; $i++){
			# code...
			$this->resultado_user_id[$i] = $this->resultado_user[$i]->id;
			$this->empleado_id[$i] = $this->resultado_user[$i]->empleado_id;
		}
		$this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
		'nombreResultado' => 'required',
		'nombreIndicador' => 'required',
		'presupuesto' => 'required|numeric',
		'ponderacion' => 'required|numeric',
		'proyecto_id' => 'required',
		//'user_create' => 'required',
		'estado' => 'required',
		'borrado' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Resultado::find($this->selected_id);
            $record->update([ 
			'nombreResultado' => $this-> nombreResultado,
			'nombreIndicador' => $this-> nombreIndicador,
			'presupuesto' => $this-> presupuesto,
			'proyecto_id' => $this-> proyecto_id,
			//'user_create' => $this-> user_create,
			'user_update' => Auth::user()->id,
			'estado' => $this-> estado,
			'borrado' => $this-> borrado
            ]);

			foreach ($this->resultado_user_id as $key => $value)
			{
				#code...
				$resultado = ResultadoUser::find($this->resultado_user_id[$key]);
				$resultado->update([
					'empleado_id' => $this->empleado_id[$key],
					'resultado_id' => $record->id,
					'user_create' => Auth::user()->id,
					'user_update' => null,
					'updated_at' => null,
					'estado' => 1,
					'borrado' => 0
				]);
			}

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Resultado Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Resultado::where('id', $id);
            $record->update([ 
				'user_update' => Auth::user()->id,
				'borrado' => 1
			]);
			$resultado = ResultadoUser::where('resultado_id', $id);
			$resultado->update([
				'user_update' => Auth::user()->id,
				'borrado' => 1
			]);
        }
    }
}
