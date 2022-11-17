<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Avance;
use App\Models\Actividade;
use App\Models\Resultado;
use App\Models\Proyecto;
use App\Models\Empleado;
use App\Models\Rubro;
use App\Models\Archivo;

class Avances extends Component
{
    use WithPagination;
	use WithFileUploads;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $rubro_id, $descripcion, $valorAsignado, $valorAnticipo, $legalizado, $empleado_id, $actividad_id, $user_create, $user_update, $estado, $borrado;
	public $observacion, $archivo, $avance_id;
	public $nombre_rubro, $proyecto_id, $resultado_id, $archivos;
    public $updateMode = false;
	public $fileMode = false;

    public function render()
    {
		$mdl = 16;
        include('Include/permisos.php');

        if($ver == 0) {
			return view('error');
		}
        else {
			$keyWord = '%'.$this->keyWord .'%';
			//Listado de Rubros
			$rubros = Rubro::where('nombreRubro', 'LIKE', '%'.$this->nombre_rubro.'%')->where('borrado', 0)->get();
			//Listado de Proyectos
			$proyectos = Proyecto::where('borrado', 0)->get();
			//Listado de Resultados
			if($this->keyWord != NULL)
			{
				$resultados = DB::table('resultados as r')
					->leftJoin('proyectos as p', 'r.proyecto_id', 'p.id')
					->select('r.*')
					->where('p.nombreProyecto', $this->keyWord)
					->where('r.estado', 1)
					->where('r.borrado', 0)
					->get();
			}
			elseif($this->proyecto_id != null)
			{
				$resultados = Resultado::where('proyecto_id', $this->proyecto_id)->get();
			}
			else
			{
				$resultados = Resultado::where('proyecto_id', $this->proyecto_id)->get();
			}
			//Listado de Actividades
			if($this->keyWord != NULL)
			{
				$actividades = DB::table('actividades as a')
					->leftJoin('resultados as r', 'a.resultado_id', 'r.id')
					->leftJoin('proyectos as p', 'r.proyecto_id', 'p.id')
					->select('a.*')
					->where('r.nombreResultado', $this->keyWord)
					->where('a.estado', 1)
					->where('a.borrado', 0)
					->get();
			}
			elseif($this->resultado_id != null)
			{
				$actividades = Actividade::where('resultado_id', $this->resultado_id)->get();
			}
			else
			{
				$actividades = Actividade::where('resultado_id', $this->resultado_id)->get();
			}
			//Listar Actividad
			if($this->actividad_id != null)
			{
				$actividad = Actividade::find($this->actividad_id);
				$avances_filtrados = DB::table('avances as a')
					->leftJoin('rubros as r', 'a.rubro_id', 'r.id')
					->leftJoin('empleados as e', 'a.empleado_id', 'e.id')
					->leftJoin('users as u', 'e.user_id', 'u.id')
					->select('a.*', 'r.nombreRubro', 'u.nombres', 'u.apellidos')
					->where('a.actividad_id', $this->actividad_id)
					->where('a.estado', 1)
					->where('a.borrado', 0)
					->get();
			}
			else
			{
				$actividad = null;
				$avances_filtrados = null;
			}		
			//Listado de Empleados
			$empleados = DB::table('empleados as e')
				->leftJoin('areas as a', 'e.area_id', 'a.id')
				->leftJoin('organizacions as o', 'a.organizacion_id', 'o.id')
				->leftJoin('users as u', 'e.user_id', 'u.id')
				->select('e.id', 'u.nombres', 'u.apellidos', 'a.nombreArea', 'o.nombreOrganizacion')
				->where('e.estado', 1)
				->where('e.borrado', 0)
				->get();

			return view('livewire.avances.view', [
				'avances' => DB::table('avances as a')
							->leftJoin('rubros as r', 'a.rubro_id', 'r.id')
							->leftJoin('empleados as e', 'a.empleado_id', 'e.id')
							->leftJoin('users as u', 'e.user_id', 'u.id')
							->leftJoin('actividades as act', 'a.actividad_id', 'act.id')
							->leftJoin('resultados as res', 'act.resultado_id', 'res.id')
							->leftJoin('proyectos as pro', 'res.proyecto_id', 'pro.id')
							->select('a.*', 'r.nombreRubro', 'u.nombres', 'u.apellidos', 'act.nombreActividad', 'res.nombreResultado', 'pro.nombreProyecto')
							->orWhere('r.nombreRubro', 'LIKE', $keyWord)
							->orWhere('a.descripcion', 'LIKE', $keyWord)
							->orWhere('a.valorAsignado', 'LIKE', $keyWord)
							->orWhere('a.valorAnticipo', 'LIKE', $keyWord)
							->orWhere('u.nombres', 'LIKE', $keyWord)
							->orWhere('u.apellidos', 'LIKE', $keyWord)
							->orWhere('act.nombreActividad', 'LIKE', $keyWord)
							->orWhere('res.nombreResultado', 'LIKE', $keyWord)
							->orWhere('pro.nombreProyecto', 'LIKE', $keyWord)
							->orderBy('a.id', 'DESC')
							->paginate(10),
				'rubros' => $rubros,
				'proyectos' => $proyectos,
				'resultados' => $resultados,
				'actividades' => $actividades,
				'empleados' => $empleados,
				'actividad' => $actividad,
				'avances_filtrados' => $avances_filtrados,
				'crear' => $crear,
                'editar' => $editar,
                'borrar' => $borrar,
                'exportar' => $exportar,
                'importar' => $importar
			]);
		}
    }
	
    public function cancel()
    {
        $this->resetInput();
        $this->updateMode = false;
		$this->fileMode = false;
    }
	
    private function resetInput()
    {		
		$this->proyecto_id = null;
		$this->resultado_id = null;
		$this->rubro_id = null;
		$this->descripcion = null;
		$this->valorAsignado = null;
		$this->valorAnticipo = null;
		$this->legalizado = null;
		$this->empleado_id = null;
		$this->actividad_id = null;
		$this->user_create = null;
		$this->user_update = null;
		$this->estado = null;
		$this->borrado = null;
		$this->observacion = null;
		$this->archivo = null;
		
    }

    public function store()
    {
        $this->validate([
			'proyecto_id' => 'required',
			'resultado_id' => 'required',
			'rubro_id' => 'required',
			'descripcion' => 'required',
			'valorAsignado' => 'required',
			'empleado_id' => 'required',
			'actividad_id' => 'required',
        ]);

        Avance::create([ 
			'rubro_id' => $this-> rubro_id,
			'descripcion' => $this-> descripcion,
			'valorAsignado' => $this-> valorAsignado,
			'valorAnticipo' => 0,
			'legalizado' => 1,
			'empleado_id' => $this-> empleado_id,
			'actividad_id' => $this-> actividad_id,
			'user_create' => Auth::user()->id,
			'user_update' => null,
			'estado' => 1,
			'borrado' => 0
        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Avance Successfully created.');
    }

    public function edit($id)
    {
        $record = Avance::findOrFail($id);
		$actividad = Actividade::find($record->actividad_id);
		$resultado = Resultado::find($actividad->resultado_id);
		$proyecto = Proyecto::find($resultado->proyecto_id);

        $this->selected_id = $id;
		$this->proyecto_id = $proyecto->id;
		$this->resultado_id = $resultado->id;
		$this->rubro_id = $record-> rubro_id;
		$this->descripcion = $record-> descripcion;
		$this->valorAsignado = $record-> valorAsignado;
		$this->valorAnticipo = $record-> valorAnticipo;
		$this->legalizado = $record-> legalizado;
		$this->empleado_id = $record-> empleado_id;
		$this->actividad_id = $record-> actividad_id;
		$this->user_create = $record-> user_create;
		$this->user_update = $record-> user_update;
		$this->estado = $record-> estado;
		$this->borrado = $record-> borrado;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
			'proyecto_id' => 'required',
			'resultado_id' => 'required',
			'rubro_id' => 'required',
			'descripcion' => 'required',
			'valorAsignado' => 'required',
			'empleado_id' => 'required',
			'actividad_id' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Avance::find($this->selected_id);
            $record->update([ 
				'rubro_id' => $this-> rubro_id,
				'descripcion' => $this-> descripcion,
				'valorAsignado' => $this-> valorAsignado,
				'empleado_id' => $this-> empleado_id,
				'actividad_id' => $this-> actividad_id,
				'user_update' => Auth::user()->id,
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Avance Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Avance::where('id', $id);
            $record->delete([ 
				'user_update' => Auth::user()->id,
				'borrado' => 1
			]);
        }
    }

	public function file($id)
	{
		$this->selected_id = $id;

		$archivos = Archivo::where('avance_id', $id)
			->where('estado', 1)
			->where('borrado', 0)
			->get();
				
		$this->archivos = $archivos;

		$this->fileMode = true;
	}

	public function savefile()
	{
		$this->validate([
            'observacion' => 'required',
			'archivo' => 'required',
			'selected_id' => 'required',
        ]);

		// Renombrar Archivo
        $file = sha1($this->archivo->getClientOriginalName().date('Y-m-d h:i:s')).'.'.$this->archivo->getClientOriginalExtension();
		// Guardar Archivo
        $this->archivo->storeAs('public/archivos', $file);
		//Registrar en base de datos
		$archivo = new Archivo();
		$archivo->observacion = $this->observacion;
		$archivo->archivo = $file;
		$archivo->avance_id = $this->selected_id;
		$archivo->user_create = Auth::user()->id;
		$archivo->user_update = null;
		$archivo->updated_at = null;
		$archivo->estado = 1;
		$archivo->borrado = 0;
		$archivo->save();

		$this->resetInput();
        $this->fileMode = false;

		session()->flash('message', 'Archivo añadido correctamente.');
	}
}
