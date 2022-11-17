<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Departamento;
use App\Models\Paise;

class Departamentos extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $codigoDepartamento, $nombreDepartamento, $pais_id, $user_create, $user_update, $estado, $borrado;
    public $updateMode = false;

    public function render()
    {
		$mdl = 6;
        include('Include/permisos.php');

        if($ver == 0) {
			return view('error');
		}
        else {
			$keyWord = '%'.$this->keyWord .'%';

			$paises = Paise::where('estado', 1)->where('borrado', 0)->get();

			return view('livewire.departamentos.view', [
				'departamentos' => DB::table('departamentos as d')
							->leftJoin('users as uc', 'd.user_create', 'uc.id')
							->leftJoin('users as uu', 'd.user_update', 'uu.id')
							->leftJoin('paises as pa', 'd.pais_id', 'pa.id')
							->select('d.*', 'pa.nombrePais', 'uc.nombres as ucnombres', 'uc.apellidos as ucapellidos', 'uu.nombres as uunombres', 'uu.apellidos as uuapellidos')
							->orWhere('d.codigoDepartamento', 'LIKE', $keyWord)
							->orWhere('d.nombreDepartamento', 'LIKE', $keyWord)
							->orWhere('pa.nombrePais', 'LIKE', $keyWord)
							->orWhere('uc.nombres', 'LIKE', $keyWord)
							->orWhere('uc.apellidos', 'LIKE', $keyWord)
							->orWhere('uu.nombres', 'LIKE', $keyWord)
							->orWhere('uu.apellidos', 'LIKE', $keyWord)
							->paginate(10),
				'paises' => $paises,
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
		$this->codigoDepartamento = null;
		$this->nombreDepartamento = null;
		$this->pais_id = null;
		$this->user_create = null;
		$this->user_update = null;
		$this->estado = null;
		$this->borrado = null;
    }

    public function store()
    {
        $this->validate([
			'codigoDepartamento' => 'required',
			'nombreDepartamento' => 'required',
			'pais_id' => 'required',
			//'user_create' => 'required',
			//'estado' => 'required',
			//'borrado' => 'required',
        ]);

        Departamento::create([ 
			'codigoDepartamento' => $this-> codigoDepartamento,
			'nombreDepartamento' => mb_strtoupper($this-> nombreDepartamento, 'UTF-8'),
			'pais_id' => $this-> pais_id,
			'user_create' => Auth::user()->id,
			'user_update' => null,
            'updated_at' => null,
			'estado' => 1,
			'borrado' => 0
        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Departamento Successfully created.');
    }

    public function edit($id)
    {
        $record = Departamento::findOrFail($id);

        $this->selected_id = $id; 
		$this->codigoDepartamento = $record-> codigoDepartamento;
		$this->nombreDepartamento = $record-> nombreDepartamento;
		$this->pais_id = $record-> pais_id;
		$this->user_create = $record-> user_create;
		$this->user_update = $record-> user_update;
		$this->estado = $record-> estado;
		$this->borrado = $record-> borrado;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
			'codigoDepartamento' => 'required',
			'nombreDepartamento' => 'required',
			'pais_id' => 'required',
			//'user_create' => 'required',
			'estado' => 'required',
			'borrado' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Departamento::find($this->selected_id);
            $record->update([ 
				'codigoDepartamento' => mb_strtoupper($this-> codigoDepartamento, 'UTF-8'),
				'nombreDepartamento' => $this-> nombreDepartamento,
				'pais_id' => $this-> pais_id,
				//'user_create' => $this-> user_create,
				'user_update' => Auth::user()->id,
				'estado' => $this-> estado,
				'borrado' => $this-> borrado
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Departamento Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Departamento::where('id', $id);
            $record->delete([
				'user_update' => Auth::user()->id,
				'borrado' => 1
			]);
        }
    }
}
