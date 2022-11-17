<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Modulo;

class Modulos extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $nombreModulo, $user_create, $user_update, $estado, $borrado;
    public $updateMode = false;

    public function render()
    {
        $mdl = 2;
        include('Include/permisos.php');

        if($ver == 0) {
			return view('error');
		}
        else {

            $keyWord = '%'.$this->keyWord .'%';
            return view('livewire.modulos.view', [
                'modulos' => DB::table('modulos as m') 
                            ->leftJoin('users as uc', 'm.user_create', 'uc.id')
                            ->leftJoin('users as uu', 'm.user_update', 'uu.id')
                            ->select('m.*', 'uc.nombres as ucnombres', 'uc.apellidos as ucapellidos', 'uu.nombres as uunombres', 'uu.apellidos as uuapellidos')             
                            ->orWhere('m.nombreModulo', 'LIKE', $keyWord)
                            ->orWhere('uc.nombres', 'LIKE', $keyWord)
                            ->orWhere('uc.apellidos', 'LIKE', $keyWord)
                            ->orWhere('uu.nombres', 'LIKE', $keyWord)
                            ->orWhere('uu.apellidos', 'LIKE', $keyWord)
                            ->orWhere('m.user_create', 'LIKE', $keyWord)
                            ->orWhere('m.user_update', 'LIKE', $keyWord)
                            ->orWhere('m.estado', 'LIKE', $keyWord)
                            ->orWhere('m.borrado', 'LIKE', $keyWord)
                            ->orderBy('m.id', 'DESC')
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
		$this->nombreModulo = null;
		$this->user_create = null;
		$this->user_update = null;
		$this->estado = null;
		$this->borrado = null;
    }

    public function store()
    {
        $this->validate([
		'nombreModulo' => 'required',
		//'user_create' => 'required',
		//'estado' => 'required',
		//'borrado' => 'required',
        ]);

        Modulo::create([ 
			'nombreModulo' => $this-> nombreModulo,
			'user_create' => Auth::user()->id,
			'user_update' => NULL,
            'updated_at' => null,
			'estado' => 1,
			'borrado' => 0
        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Modulo Successfully created.');
    }

    public function edit($id)
    {
        $record = Modulo::findOrFail($id);

        $this->selected_id = $id; 
		$this->nombreModulo = $record-> nombreModulo;
		$this->user_create = $record-> user_create;
		$this->user_update = $record-> user_update;
		$this->estado = $record-> estado;
		$this->borrado = $record-> borrado;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
		'nombreModulo' => 'required',
		//'user_create' => 'required',
		'estado' => 'required',
		//'borrado' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Modulo::find($this->selected_id);
            $record->update([ 
			'nombreModulo' => $this-> nombreModulo,
			//'user_create' => $this-> user_create,
			'user_update' => Auth::user()->id,
			'estado' => $this-> estado,
			'borrado' => 0
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Modulo Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Modulo::where('id', $id);
            $record->delete([
                'user_update' => Auth::user()->id,
                'borrado' => 1
                ]);
        }
    }
}
