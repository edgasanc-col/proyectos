<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Empleado;
use App\Models\Area;
use App\Models\User;

class Empleados extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $user_id, $area_id, $nombres, $apellidos, $tipo_doc, $cedula, $email, $img_user, $user_create, $user_update, $estado, $borrado;
    public $updateMode = false;

    public function render()
    {
        $mdl = 10;
        include('Include/permisos.php');

        if($ver == 0) {
			return view('error');
		}
        else {
            $keyWord = '%'.$this->keyWord .'%';

            $areas = Area::where('estado', 1)->where('borrado', 0)->get();
            $user = User::where('estado', 1)->where('borrado', 0)->get();

            return view('livewire.empleados.view', [
                'empleados' => DB::table('empleados as e')
                            ->leftJoin('users as uc', 'e.user_create', 'uc.id')
                            ->leftJoin('users as uu', 'e.user_update', 'uu.id')
                            ->leftJoin('areas as a', 'e.area_id', 'a.id')
                            ->leftJoin('users as u', 'e.user_id', 'u.id')
                            ->select('e.*', 'u.nombres', 'u.apellidos', 'a.nombreArea','uc.nombres as ucnombres', 'uc.apellidos as ucapellidos', 'uu.nombres as uunombres', 'uu.apellidos as uuapellidos')
                            ->orWhere('e.user_id', 'LIKE', $keyWord)
                            ->orWhere('u.nombres', 'LIKE', $keyWord)
                            ->orWhere('u.apellidos', 'LIKE', $keyWord)
                            ->orWhere('a.nombreArea', 'LIKE', $keyWord)
                            ->orWhere('uc.nombres', 'LIKE', $keyWord)
                            ->orWhere('uc.apellidos', 'LIKE', $keyWord)
                            ->orWhere('uu.nombres', 'LIKE', $keyWord)
                            ->orWhere('uu.apellidos', 'LIKE', $keyWord)
                            ->orderBy('e.id', 'DESC')
                            ->paginate(10),
                'areas' => $areas,
                'users' => $user,
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
		$this->user_id = null;
		$this->area_id = null;
		$this->user_create = null;
		$this->user_update = null;
		$this->estado = null;
		$this->borrado = null; 
        $this->nombres = null;
		$this->apellidos = null;
		$this->tipo_doc = null;
		$this->cedula = null;
		$this->email = null;
		$this->img_user = null;
    }

    public function store()
    {
        $this->validate([
            //'user_id' => 'required',
            'area_id' => 'required',
            'nombres' => 'required',
            'apellidos' => 'required',
            'tipo_doc' => 'required',
            'cedula' => 'required',
            'email' => 'required|unique:users',
            //'img_user' => 'required',
            //'user_create' => 'required',
            //'estado' => 'required',
            //'borrado' => 'required',
        ]);

        //Registrar usuario
        $user = new User();
        $user->nombres = mb_strtoupper($this->nombres, 'UTF-8');
        $user->apellidos = mb_strtoupper($this->apellidos, 'UTF-8');
        $user->tipo_doc = $this->tipo_doc;
        $user->cedula = $this->cedula;
        $user->email = mb_strtolower($this->email, 'UTF-8');
        $user->password = Hash::make($this->cedula);
        $user->img_user = null;
        $user->rol_id = 6;
        $user->updated_at = null;
        $user->estado = 1;
        $user->borrado = 0;
        $user->save();

        //Registrar Empleado
        $empleado = new Empleado();
        $empleado->user_id = $user->id;
        $empleado->area_id = $this->area_id;
        $empleado->user_create = Auth::user()->id;
		$empleado->user_update = NULL;
		$empleado->updated_at = NULL;
		$empleado->estado = 1;
        $empleado->borrado = 0;
        $empleado->save();

        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Empleado Successfully created.');
    }

    public function edit($id)
    {
        $record = Empleado::findOrFail($id);
        $user = User::find($record->user_id);

        $this->selected_id = $id; 
		$this->user_id = $record-> user_id;
		$this->area_id = $record-> area_id;
		$this->user_create = $record-> user_create;
		$this->user_update = $record-> user_update;
		$this->estado = $record-> estado;
		$this->borrado = $record-> borrado;
		
		$this->tipo_doc = $user->tipo_doc;
		$this->cedula = $user->cedula;
        $this->nombres = $user->nombres;
		$this->apellidos = $user->apellidos;
        $this->email = $user->email;

        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
            'user_id' => 'required',
            'area_id' => 'required',
            'nombres' => 'required',
            'apellidos' => 'required',
            'tipo_doc' => 'required',
            'cedula' => 'required',
            'email' => 'required',
            //'user_create' => 'required',
            'estado' => 'required',
            'borrado' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Empleado::find($this->selected_id);
            $record->update([ 
                'user_id' => $this-> user_id,
                'area_id' => $this-> area_id,
                //'user_create' => $this-> user_create,
                'user_update' => $this-> user_update,
                'estado' => $this-> estado,
                //'borrado' => $this-> borrado
            ]);

            $user = User::find($record->user_id);
            $user->update([ 
                'nombres' => mb_strtoupper($this-> nombres, 'UTF-8'),
                'apellidos' => mb_strtoupper($this-> apellidos, 'UTF-8'),
                'tipo_doc' => $this-> tipo_doc,
                'cedula' => $this-> cedula,
                'email' => mb_strtolower($this-> email, 'UTF-8')
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Empleado Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Empleado::where('id', $id);
            $record->delete([ 
				'user_update' => Auth::user()->id,
				'borrado' => 1
				]);
        }
    }
}
