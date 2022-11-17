<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Anticipo;
use App\Models\AprobacionAnticipo;
use App\Models\Proyecto;
use App\Models\Resultado;
use App\Models\Actividade;
use App\Models\Avance;

class Anticipos extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $valorAnticipo, $nit, $razon_social, $descripcion, $legalizado, $avance_id, $user_create, $user_update, $estado, $borrado;
	public $proyecto_id, $resultado_id, $actividad_id, $comentario, $anticipo_id;
    public $updateMode = false;
	public $aprobarMode = false;

    public function render()
    {
		$mdl = 17;
        include('Include/permisos.php');

        if($ver == 0) {
			return view('error');
		}
        else {
			$keyWord = '%'.$this->keyWord .'%';

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
			//Listado de Avances
			if($this->keyWord != NULL)
			{
				$avances = DB::table('avances as av')
					->leftJoin('actividades as a', 'av.actividad_id', 'a.id')
					->leftJoin('resultados as r', 'a.resultado_id', 'r.id')
					->leftJoin('proyectos as p', 'r.proyecto_id', 'p.id')
					->select('av.*')
					->where('a.nombreActividad', $this->keyWord)
					->where('av.estado', 1)
					->where('av.borrado', 0)
					->get();
			}
			elseif($this->resultado_id != null)
			{
				$avances = Avance::where('actividad_id', $this->actividad_id)->get();
			}
			else
			{
				$avances = Avance::where('actividad_id', $this->actividad_id)->get();
			}
			//Avance
			if($this->avance_id != NULL)
			{
				$avance = Avance::find($this->avance_id);
			}
			else
			{
				$avance = NULL;
			}
			//Aprobacion Anticipos
			if($this->anticipo_id != NULL && $this->aprobarMode == true)
			{
				$aprobacion_anticipos = DB::table('aprobacion_anticipos as aa')
											->leftJoin('users as uc', 'aa.user_create', 'uc.id')
											->select('aa.*', 'uc.nombres', 'uc.apellidos')
											->where('aa.anticipo_id', $this->anticipo_id)
											->get();
			}
			else
			{
				$aprobacion_anticipos = NULL;
			}

			return view('livewire.anticipos.view', [
				'anticipos' => DB::table('anticipos as ant')
							->leftJoin('avances as a', 'ant.avance_id', 'a.id')
							->leftJoin('users as uc', 'ant.user_create', 'uc.id')
							->leftJoin('users as uu', 'ant.user_update', 'uu.id')
							->select('ant.*', 'a.descripcion as adescripcion', 'uc.nombres as ucnombres', 'uc.apellidos as ucapellidos', 'uu.nombres as uunombres', 'uu.apellidos as uuapellidos')
							->orWhere('ant.valorAnticipo', 'LIKE', $keyWord)
							->orWhere('ant.descripcion', 'LIKE', $keyWord)
							->orWhere('a.descripcion', 'LIKE', $keyWord)
							->orderBy('ant.id', 'DESC')
							->paginate(10),
				'crear' => $crear,
                'editar' => $editar,
                'borrar' => $borrar,
                'exportar' => $exportar,
                'importar' => $importar,
				'ver' => $ver,
				'proyectos' => $proyectos,
				'resultados' => $resultados,
				'actividades' => $actividades,
				'avances' => $avances,
				'avance' => $avance,
				'aprobacion_anticipos' => $aprobacion_anticipos
			]);
		}
    }
	
    public function cancel()
    {
        $this->resetInput();
        $this->updateMode = false;
		$this->aprobarMode = false;
    }
	
    private function resetInput()
    {		
		$this->valorAnticipo = null;
		$this->nit = null;
		$this->razon_social = null;
		$this->descripcion = null;
		$this->legalizado = null;
		$this->avance_id = null;
		$this->comentario = null;
		$this->anticipo_id = null;
		$this->user_create = null;
		$this->user_update = null;
		$this->estado = null;
		$this->borrado = null;
    }

    public function store()
    {
        $this->validate([
			'valorAnticipo' => 'required',
			'nit' => 'required|numeric',
			'razon_social' => 'required|string|max:250',
			'descripcion' => 'required',
			'avance_id' => 'required',
        ]);

        Anticipo::create([ 
			'valorAnticipo' => $this-> valorAnticipo,
			'nit' => $this-> nit,
			'razon_social' => $this-> razon_social,
			'descripcion' => $this-> descripcion,
			'legalizado' => 2,
			'avance_id' => $this-> avance_id,
			'user_create' => Auth::user()->id,
			'user_update' => NULL,
			'estado' => 1,
			'borrado' => 0
        ]);

		$avance = Avance::find($this->avance_id);
		if($avance->valorAnticipo == 0)
		{
			$avance->valorAnticipo = $this->valorAnticipo;	
		}
		else
		{
			$avance->valorAnticipo += $this->valorAnticipo;
		}
		$avance->legalizado = 2;
		$avance->user_update = Auth::user()->id;
		$avance->save();
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Anticipo Successfully created.');
    }

    public function edit($id)
    {
        $record = Anticipo::findOrFail($id);

        $this->selected_id = $id; 
		$this->valorAnticipo = $record-> valorAnticipo;
		$this->nit = $record-> nit;
		$this->razon_social = $record-> razon_social;
		$this->descripcion = $record-> descripcion;
		$this->legalizado = $record-> legalizado;
		$this->avance_id = $record-> avance_id;
		$this->user_create = $record-> user_create;
		$this->user_update = $record-> user_update;
		$this->estado = $record-> estado;
		$this->borrado = $record-> borrado;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
			'valorAnticipo' => 'required',
			'nit' => 'required|numeric',
			'razon_social' => 'required|string|max:250',
			'descripcion' => 'required',
			'avance_id' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Anticipo::find($this->selected_id);
            $record->update([ 
				'valorAnticipo' => $this-> valorAnticipo,
				'nit' => $this-> nit,
				'razon_social' => $this-> razon_social,
				'descripcion' => $this-> descripcion,
				'avance_id' => $this-> avance_id,
				'user_update' => Auth::user()->id,
            ]);

			$avance = Avance::find($this->avance_id);
			$avance->valorAnticipo = $this->valorAnticipo;
			$avance->legalizado = 2;
			$avance->user_update = Auth::user()->id;
			$avance->save();

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Anticipo Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Anticipo::where('id', $id);
            $record->update([
				'borrado' => 1
			]);
        }
    }

	public function aprobar($id)
	{
		$record = Anticipo::findOrFail($id);
		$this->anticipo_id = $record->id;
		$this->descripcion = $record->descripcion;
		$this->valorAnticipo = $record->valorAnticipo;

		$this->aprobarMode = true;
	}

	public function store_aprobacion()
	{
		$this->validate([
			'anticipo_id' => 'required|numeric',
			'comentario' => 'required|string|max:200',
			'legalizado' => 'required|numeric'
        ]);

		AprobacionAnticipo::create([
			'comentario' => $this->comentario,
			'legalizado' => $this->legalizado,
			'anticipo_id' => $this->anticipo_id,
			'user_create' => Auth::user()->id,
			'user_update' => NULL,
			'updated_at' => NULL,
			'estado' => 1,
			'borrado' => 0,
		]);

		$anticipo = Anticipo::find($this->anticipo_id);
		$anticipo->legalizado = $this->legalizado;
		$anticipo->user_update = Auth::user()->id;
		$anticipo->save();

		$avance = Avance::find($anticipo->avance_id);
		$avance->legalizado = $this->legalizado;
		$avance->user_update = Auth::user()->id;
		$avance->save();

		$this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Comentario Anticipo Successfully created.');
	}
}
