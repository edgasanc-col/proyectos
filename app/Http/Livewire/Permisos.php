<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Permiso;
use App\Models\Role;
use App\Models\Modulo;

class Permisos extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $rol_id, $modulo_id, $crear, $ver, $editar, $borrar, $importar, $exportar, $user_create, $user_update, $estado, $borrado;
    public $updateMode = false;

    public function render()
    {
		$mdl = 3;
        include('Include/permisos.php');

        if($ver == 0) {
			return view('error');
		}
        else {

			$keyWord = '%'.$this->keyWord .'%';
			
			$roles = Role::where('estado', 1)->where('borrado', 0)->get();
			$modulos = Modulo::where('estado', 1)->where('borrado', 0)->get();

			return view('livewire.permisos.view', [
				'permisos' => DB::table('permisos as p')
							->leftJoin('users as uc', 'p.user_create', 'uc.id')
							->leftJoin('users as uu', 'p.user_update', 'uu.id')
							->leftJoin('roles as r', 'p.rol_id', 'r.id')
							->leftJoin('modulos as m', 'p.modulo_id', 'm.id')							
							->select('p.*', 'm.nombreModulo', 'r.nombreRol', 'uc.nombres as ucnombres', 'uc.apellidos as ucapellidos', 'uu.nombres as uunombres', 'uu.apellidos as uuapellidos')
							->orWhere('p.rol_id', 'LIKE', $keyWord)
							->orWhere('p.modulo_id', 'LIKE', $keyWord)
							->orWhere('r.nombreRol', 'LIKE', $keyWord)
							->orWhere('m.nombreModulo', 'LIKE', $keyWord)
							->orWhere('uc.nombres', 'LIKE', $keyWord)
							->orWhere('uc.apellidos', 'LIKE', $keyWord)
							->orWhere('uu.nombres', 'LIKE', $keyWord)
							->orWhere('uu.apellidos', 'LIKE', $keyWord)
							->orderBy('p.id', 'DESC')
							->paginate(10),
				'roles' => $roles,
				'modulos' => $modulos,
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
		$this->rol_id = null;
		$this->modulo_id = null;
		$this->crear = null;
		$this->ver = null;
		$this->editar = null;
		$this->borrar = null;
		$this->importar = null;
		$this->exportar = null;
		$this->user_create = null;
		$this->user_update = null;
		$this->estado = null;
		$this->borrado = null;
    }

    public function store()
    {
        $this->validate([
		'rol_id' => 'required',
		'modulo_id' => 'required',
		'crear' => 'required',
		'ver' => 'required',
		'editar' => 'required',
		'borrar' => 'required',
		'importar' => 'required',
		'exportar' => 'required',
        ]);

        Permiso::create([ 
			'rol_id' => $this-> rol_id,
			'modulo_id' => $this-> modulo_id,
			'crear' => $this-> crear,
			'ver' => $this-> ver,
			'editar' => $this-> editar,
			'borrar' => $this-> borrar,
			'importar' => $this-> importar,
			'exportar' => $this-> exportar,
			'user_create' => Auth::user()->id,
			'user_update' => null,
			'updated_at' => null,
			'estado' => 1,
			'borrado' => 0
        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Permiso Successfully created.');
    }

    public function edit($id)
    {
        $record = Permiso::findOrFail($id);

        $this->selected_id = $id; 
		$this->rol_id = $record-> rol_id;
		$this->modulo_id = $record-> modulo_id;
		$this->crear = $record-> crear;
		$this->ver = $record-> ver;
		$this->editar = $record-> editar;
		$this->borrar = $record-> borrar;
		$this->importar = $record-> importar;
		$this->exportar = $record-> exportar;
		$this->user_create = $record-> user_create;
		$this->user_update = $record-> user_update;
		$this->estado = $record-> estado;
		$this->borrado = $record-> borrado;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
		'rol_id' => 'required',
		'modulo_id' => 'required',
		'crear' => 'required',
		'ver' => 'required',
		'editar' => 'required',
		'borrar' => 'required',
		'importar' => 'required',
		'exportar' => 'required',
		'user_create' => 'required',
		'estado' => 'required',
		'borrado' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Permiso::find($this->selected_id);
            $record->update([ 
			'rol_id' => $this-> rol_id,
			'modulo_id' => $this-> modulo_id,
			'crear' => $this-> crear,
			'ver' => $this-> ver,
			'editar' => $this-> editar,
			'borrar' => $this-> borrar,
			'importar' => $this-> importar,
			'exportar' => $this-> exportar,
			'user_create' => $this-> user_create,
			'user_update' => Auth::user()->id,
			'estado' => $this-> estado,
			'borrado' => $this-> borrado
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Permiso Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Permiso::where('id', $id);
            $record->delete([
				'user_update' => Auth::user()->id,
				'borrado' => 1
				]);
        }
    }
}
