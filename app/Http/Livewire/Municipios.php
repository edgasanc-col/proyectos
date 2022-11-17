<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Municipio;
use App\Models\Departamento;

class Municipios extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $codigoMunicipio, $nombreMunicipio, $departamento_id, $user_create, $user_update, $estado, $borrado;
    public $updateMode = false;

    public function render()
    {
		$mdl = 7;
        include('Include/permisos.php');

        if($ver == 0) {
			return view('error');
		}
        else {
			$keyWord = '%'.$this->keyWord .'%';

			$departamentos = Departamento::where('estado', 1)->where('borrado', 0)->get();

			return view('livewire.municipios.view', [
				'municipios' => DB::table('municipios as mu')
							->leftJoin('users as uc', 'mu.user_create', 'uc.id')
							->leftJoin('users as uu', 'mu.user_update', 'uu.id')
							->leftJoin('departamentos as d', 'mu.departamento_id', 'd.id')
							->select('mu.*', 'd.nombreDepartamento', 'uc.nombres as ucnombres', 'uc.apellidos as ucapellidos', 'uu.nombres as uunombres', 'uu.apellidos as uuapellidos')
							->orWhere('mu.codigoMunicipio', 'LIKE', $keyWord)
							->orWhere('mu.nombreMunicipio', 'LIKE', $keyWord)
							->orWhere('d.nombreDepartamento', 'LIKE', $keyWord)
							->orWhere('uc.nombres', 'LIKE', $keyWord)
							->orWhere('uc.apellidos', 'LIKE', $keyWord)
							->orWhere('uu.nombres', 'LIKE', $keyWord)
							->orWhere('uu.apellidos', 'LIKE', $keyWord)
							->orderBy('mu.id', 'DESC')
							->paginate(10),
				'departamentos' => $departamentos,
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
    }
	
    private function resetInput()
    {		
		$this->codigoMunicipio = null;
		$this->nombreMunicipio = null;
		$this->departamento_id = null;
		$this->user_create = null;
		$this->user_update = null;
		$this->estado = null;
		$this->borrado = null;
    }

    public function store()
    {
        $this->validate([
			'codigoMunicipio' => 'required',
			'nombreMunicipio' => 'required',
			'departamento_id' => 'required',
			//'user_create' => 'required',
			//'estado' => 'required',
			//'borrado' => 'required',
        ]);

        Municipio::create([ 
			'codigoMunicipio' => $this-> codigoMunicipio,
			'nombreMunicipio' => mb_strtoupper($this-> nombreMunicipio, 'UTF-8'),
			'departamento_id' => $this-> departamento_id,
			'user_create' => Auth::user()->id,
			'user_update' => null,
			'updated_at' => null,
			'estado' => 1,
			'borrado' => 0
        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Municipio Successfully created.');
    }

    public function edit($id)
    {
        $record = Municipio::findOrFail($id);

        $this->selected_id = $id; 
		$this->codigoMunicipio = $record-> codigoMunicipio;
		$this->nombreMunicipio = $record-> nombreMunicipio;
		$this->departamento_id = $record-> departamento_id;
		$this->user_create = $record-> user_create;
		$this->user_update = $record-> user_update;
		$this->estado = $record-> estado;
		$this->borrado = $record-> borrado;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
			'codigoMunicipio' => 'required',
			'nombreMunicipio' => 'required',
			'departamento_id' => 'required',
			//'user_create' => 'required',
			'estado' => 'required',
			'borrado' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Municipio::find($this->selected_id);
            $record->update([ 
				'codigoMunicipio' => $this-> codigoMunicipio,
				'nombreMunicipio' => mb_strtoupper($this-> nombreMunicipio, 'UTF-8'),
				'departamento_id' => $this-> departamento_id,
				//'user_create' => $this-> user_create,
				'user_update' => Auth::user()->id,
				'estado' => $this-> estado,
				'borrado' => $this-> borrado
			]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Municipio Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Municipio::where('id', $id);
            $record->delete([ 
				'user_update' => Auth::user()->id,
				'borrado' => 1
				]);
        }
    }
}
