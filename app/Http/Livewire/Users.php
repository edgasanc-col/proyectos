<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Role;

class Users extends Component
{
    use WithPagination;
	use WithFileUploads;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $nombres, $apellidos, $tipo_doc, $cedula, $email, $password, $img_user, $rol_id, $estado, $borrado;
    public $updateMode = false;

    public function render()
    {
		$mdl = 4;
        include('Include/permisos.php');

        if($ver == 0) {
			return view('error');
		}
        else {
			$keyWord = '%'.$this->keyWord .'%';

			$roles = Role::where('estado', 1)->where('borrado', 0)->get();

			return view('livewire.users.view', [
				'users' => DB::table('users as u')
							->leftJoin('roles as r', 'u.rol_id', 'r.id')
							->select('u.*', 'r.nombreRol')
							->orWhere('r.nombreRol', 'LIKE', $keyWord)
							->orWhere('u.nombres', 'LIKE', $keyWord)
							->orWhere('u.apellidos', 'LIKE', $keyWord)
							->orWhere('u.tipo_doc', 'LIKE', $keyWord)
							->orWhere('u.cedula', 'LIKE', $keyWord)
							->orWhere('u.email', 'LIKE', $keyWord)
							->orWhere('u.img_user', 'LIKE', $keyWord)
							->orderBy('u.id', 'DESC')
							->paginate(10),
				'roles' => $roles,
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
		$this->nombres = null;
		$this->apellidos = null;
		$this->tipo_doc = null;
		$this->cedula = null;
		$this->email = null;
		$this->img_user = null;
		$this->rol_id = null;
		$this->estado = null;
		$this->borrado = null;
    }

    public function store()
    {
        $this->validate([
			'nombres' => 'required|string|max:100',
			'apellidos' => 'required|string|max:100',
			'tipo_doc' => 'required|numeric',
			'cedula' => 'required|numeric|unique:users',
			'email' => 'required|email|unique:users',
			'password' => 'required|string|min:6',
			'rol_id' => 'required|numeric',
        ]);

        User::create([ 
			'nombres' => mb_strtoupper($this-> nombres, 'UTF-8'),
			'apellidos' => mb_strtoupper($this-> apellidos, 'UTF-8'),
			'tipo_doc' => $this->tipo_doc,
			'cedula' => $this->cedula,
			'email' => mb_strtolower($this-> email, 'UTF-8'),
			'password' => Hash::make($this-> password),
			'img_user' => null,
			'rol_id' => $this-> rol_id,
			'estado' => 1,
			'borrado' => 0
        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'User Successfully created.');
    }

    public function edit($id)
    {
        $record = User::findOrFail($id);

        $this->selected_id = $id; 
		$this->nombres = $record-> nombres;
		$this->apellidos = $record-> apellidos;
		$this->tipo_doc = $record-> tipo_doc;
		$this->cedula = $record-> cedula;
		$this->email = $record-> email;
		$this->img_user = $record-> img_user;
		$this->rol_id = $record-> rol_id;
		$this->estado = $record-> estado;
		$this->borrado = $record-> borrado;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
			'nombres' => 'required|string|max:100',
			'apellidos' => 'required|string|max:100',
			'tipo_doc' => 'required|numeric',
			'cedula' => 'required|numeric',
			'email' => 'required|email|',
			'password' => 'required|string|min:6',
			'rol_id' => 'required|numeric',
			'estado' => 'required|numeric',
        ]);

        if ($this->selected_id) {
			$record = User::find($this->selected_id);
            $record->update([ 
				'nombres' => mb_strtoupper($this-> nombres, 'UTF-8'),
				'apellidos' => mb_strtoupper($this-> apellidos, 'UTF-8'),
				'tipo_doc' => $this-> tipo_doc,
				'cedula' => $this-> cedula,
				'email' => mb_strtolower($this-> email, 'UTF-8'),
				'password' => Hash::make($this-> password),
				'img_user' => null,
				'rol_id' => $this-> rol_id,
				'estado' => $this-> estado,
				//'borrado' => $this-> borrado
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'User Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = User::where('id', $id);
            $record->update([
				'borrado' => 1
			]);
        }
    }
}
