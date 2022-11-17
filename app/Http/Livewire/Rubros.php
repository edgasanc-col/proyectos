<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Rubro;

class Rubros extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $nombreRubro, $codigoContable, $subCuenta, $user_create, $user_update, $estado, $borrado;
    public $updateMode = false;

    public function render()
    {
		$mdl = 11;
        include('Include/permisos.php');

        if($ver == 0) {
			return view('error');
		}
        else {
			$keyWord = '%'.$this->keyWord .'%';
			return view('livewire.rubros.view', [
				'rubros' => DB::table('rubros as r')
							->leftJoin('users as uc', 'r.user_create', 'uc.id')
							->leftJoin('users as uu', 'r.user_update', 'uu.id')
							->select('r.*', 'uc.nombres as ucnombres', 'uc.apellidos as ucapellidos', 'uu.nombres as uunombres', 'uu.apellidos as uuapellidos')
							->orWhere('r.nombreRubro', 'LIKE', $keyWord)
							->orWhere('r.codigoContable', 'LIKE', $keyWord)
							->orWhere('r.subCuenta', 'LIKE', $keyWord)
							->orWhere('uc.nombres', 'LIKE', $keyWord)
							->orWhere('uc.apellidos', 'LIKE', $keyWord)
							->orWhere('uu.nombres', 'LIKE', $keyWord)
							->orWhere('uu.apellidos', 'LIKE', $keyWord)
							->orderBy('r.id', 'DESC')
							->paginate(10),
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
		$this->nombreRubro = null;
		$this->codigoContable = null;
		$this->subCuenta = null;
		$this->user_create = null;
		$this->user_update = null;
		$this->estado = null;
		$this->borrado = null;
    }

    public function store()
    {
        $this->validate([
			'nombreRubro' => 'required',
			'codigoContable' => 'required',
			'subCuenta' => 'required|numeric',
			//'user_create' => 'required',
			//'estado' => 'required',
			//'borrado' => 'required',
        ]);

        Rubro::create([ 
			'nombreRubro' => mb_strtoupper($this-> nombreRubro, 'UTF-8'),
			'codigoContable' => $this-> codigoContable,
			'subCuenta' => $this-> subCuenta,
			'user_create' => Auth::user()->id,
			'user_update' => null,
            'updated_at' => null,
			'estado' => 1,
			'borrado' => 0
        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Rubro Successfully created.');
    }

    public function edit($id)
    {
        $record = Rubro::findOrFail($id);

        $this->selected_id = $id; 
		$this->nombreRubro = $record-> nombreRubro;
		$this->codigoContable = $record-> codigoContable;
		$this->subCuenta = $record-> subCuenta;
		$this->user_create = $record-> user_create;
		$this->user_update = $record-> user_update;
		$this->estado = $record-> estado;
		$this->borrado = $record-> borrado;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
			'nombreRubro' => 'required',
			'codigoContable' => 'required',
			'subCuenta' => 'required|numeric',
			//'user_create' => 'required',
			'estado' => 'required|numeric',
			//'borrado' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Rubro::find($this->selected_id);
            $record->update([ 
				'nombreRubro' => $this-> nombreRubro,
				'codigoContable' => $this-> codigoContable,
				'subCuenta' => $this-> subCuenta,
				//'user_create' => $this-> user_create,
				'user_update' => Auth::user()->id,
				'estado' => $this-> estado,
				//'borrado' => $this-> borrado
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Rubro Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Rubro::where('id', $id);
            $record->delete([
				'user_update' => Auth::user()->id,
				'borrado' => 1
			]);
        }
    }
}
