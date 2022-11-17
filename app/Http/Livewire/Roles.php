<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class Roles extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $nombreRol, $user_create, $user_update, $estado, $borrado;
    public $updateMode = false;

    public function render()
    {
        $mdl = 1;
        include('Include/permisos.php');

        if($ver == 0) {
			return view('error');
		}
        else {
            $keyWord = '%'.$this->keyWord .'%';
            return view('livewire.roles.view', [
                'roles' => DB::table('roles as r')
                    ->leftJoin('users as uc', 'r.user_create', 'uc.id')
                    ->leftJoin('users as uu', 'r.user_update', 'uu.id')
                    ->select('r.*', 'uc.nombres as ucnombres', 'uc.apellidos as ucapellidos', 'uu.nombres as uunombres', 'uu.apellidos as uuapellidos')
					->orWhere('r.nombreRol', 'LIKE', $keyWord)
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
		$this->nombreRol = null;
		$this->user_create = null;
		$this->user_update = null;
		$this->estado = null;
		$this->borrado = null;
    }

    public function store()
    {
        $this->validate([
		'nombreRol' => 'required',
		//'user_create' => 'required',
		//'estado' => 'required',
		//'borrado' => 'required',
        ]);

        Role::create([ 
			'nombreRol' => $this-> nombreRol,
			'user_create' => Auth::user()->id,
			'user_update' => NULL,
            'updated_at' => null,
			'estado' => 1,
			'borrado' => 0
        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Role Successfully created.');
    }

    public function edit($id)
    {
        $record = Role::findOrFail($id);

        $this->selected_id = $id; 
		$this->nombreRol = $record-> nombreRol;
		$this->user_create = $record-> user_create;
		$this->user_update = $record-> user_update;
		$this->estado = $record-> estado;
		$this->borrado = $record-> borrado;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
		'nombreRol' => 'required',
		//'user_create' => 'required',
		'estado' => 'required',
		//'borrado' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Role::find($this->selected_id);
            $record->update([ 
			'nombreRol' => $this-> nombreRol,
			//'user_create' => $this-> user_create,
			'user_update' => Auth::user()->id,
			'estado' => $this-> estado,
			'borrado' => 0
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Role Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Role::where('id', $id);
            $record->update([
                'user_update' => Auth::user()->id,
                'borrado' => 1
                ]);
        }
    }
}
