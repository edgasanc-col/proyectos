<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Donante;

class Donantes extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $nombreDonante, $user_create, $user_update, $estado, $borrado;
    public $updateMode = false;

    public function render()
    {
        $mdl = 12;
        include('Include/permisos.php');

        if($ver == 0) {
			return view('error');
		}
        else {
            $keyWord = '%'.$this->keyWord .'%';
            return view('livewire.donantes.view', [
                'donantes' => DB::table('donantes as do')
                            ->leftJoin('users as uc', 'do.user_create', 'uc.id')
                            ->leftJoin('users as uu', 'do.user_update', 'uu.id')
                            ->select('do.*', 'uc.nombres as ucnombres', 'uc.apellidos as ucapellidos', 'uu.nombres as uunombres', 'uu.apellidos as uuapellidos')
                            ->orWhere('do.nombreDonante', 'LIKE', $keyWord)
                            ->orWhere('uc.nombres', 'LIKE', $keyWord)
                            ->orWhere('uc.apellidos', 'LIKE', $keyWord)
                            ->orWhere('uu.nombres', 'LIKE', $keyWord)
                            ->orWhere('uu.apellidos', 'LIKE', $keyWord)
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
		$this->nombreDonante = null;
		$this->user_create = null;
		$this->user_update = null;
		$this->estado = null;
		$this->borrado = null;
    }

    public function store()
    {
        $this->validate([
            'nombreDonante' => 'required',
            //'user_create' => 'required',
            //'estado' => 'required',
            //'borrado' => 'required',
        ]);

        Donante::create([ 
			'nombreDonante' => mb_strtoupper($this-> nombreDonante, 'UTF-8'),
			'user_create' => Auth::user()->id,
			'user_update' => null,
            'updated_at' => null,
			'estado' => 1,
			'borrado' => 0
        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Donante Successfully created.');
    }

    public function edit($id)
    {
        $record = Donante::findOrFail($id);

        $this->selected_id = $id; 
		$this->nombreDonante = $record-> nombreDonante;
		$this->user_create = $record-> user_create;
		$this->user_update = $record-> user_update;
		$this->estado = $record-> estado;
		$this->borrado = $record-> borrado;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
            'nombreDonante' => 'required',
            //'user_create' => 'required',
            'estado' => 'required',
            'borrado' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Donante::find($this->selected_id);
            $record->update([ 
                'nombreDonante' => mb_strtoupper($this-> nombreDonante, 'UTF-8'),
                //'user_create' => $this-> user_create,
                'user_update' => Auth::user()->id,
                'estado' => $this-> estado,
                'borrado' => $this-> borrado
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Donante Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Donante::where('id', $id);
            $record->delete([
				'user_update' => Auth::user()->id,
				'borrado' => 1
			]);
        }
    }
}
