<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Area;
use App\Models\Organizacion;

class Areas extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $nombreArea, $organizacion_id, $user_create, $user_update, $estado, $borrado;
    public $updateMode = false;

    public function render()
    {
        $mdl = 9;
        include('Include/permisos.php');

        if($ver == 0) {
			return view('error');
		}
        else {
            $keyWord = '%'.$this->keyWord .'%';

            $organizaciones = Organizacion::where('estado', 1)->where('borrado', 0)->get();

            return view('livewire.areas.view', [
                'areas' => DB::table('areas as a')
                            ->leftJoin('users as uc', 'a.user_create', 'uc.id')
                            ->leftJoin('users as uu', 'a.user_update', 'uu.id')
                            ->leftJoin('organizacions as o', 'a.organizacion_id', 'o.id')
                            ->select('a.*', 'o.nombreOrganizacion','uc.nombres as ucnombres', 'uc.apellidos as ucapellidos', 'uu.nombres as uunombres', 'uu.apellidos as uuapellidos')
                            ->orWhere('nombreArea', 'LIKE', $keyWord)
                            ->orWhere('organizacion_id', 'LIKE', $keyWord)
                            ->orWhere('o.nombreOrganizacion', 'LIKE', $keyWord)
                            ->orWhere('uc.nombres', 'LIKE', $keyWord)
                            ->orWhere('uc.apellidos', 'LIKE', $keyWord)
                            ->orWhere('uu.nombres', 'LIKE', $keyWord)
                            ->orWhere('uu.apellidos', 'LIKE', $keyWord)
                            ->orderBy('a.id', 'DESC')
                            ->paginate(10),
                'organizacions' => $organizaciones,
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
		$this->nombreArea = null;
		$this->organizacion_id = null;
		$this->user_create = null;
		$this->user_update = null;
		$this->estado = null;
		$this->borrado = null;
    }

    public function store()
    {
        $this->validate([
            'nombreArea' => 'required',
            'organizacion_id' => 'required',
            //'user_create' => 'required',
            //'estado' => 'required',
            //'borrado' => 'required',
        ]);

        Area::create([ 
			'nombreArea' => mb_strtoupper($this-> nombreArea, 'UTF-8'),
			'organizacion_id' => $this-> organizacion_id,
			'user_create' => Auth::user()->id,
			'user_update' => null,
			'updated_at' => null,
			'estado' => 1,
			'borrado' => 0
        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Area Successfully created.');
    }

    public function edit($id)
    {
        $record = Area::findOrFail($id);

        $this->selected_id = $id; 
		$this->nombreArea = $record-> nombreArea;
		$this->organizacion_id = $record-> organizacion_id;
		$this->user_create = $record-> user_create;
		$this->user_update = $record-> user_update;
		$this->estado = $record-> estado;
		$this->borrado = $record-> borrado;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
            'nombreArea' => 'required',
            'organizacion_id' => 'required',
            //'user_create' => 'required',
            'estado' => 'required',
            'borrado' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Area::find($this->selected_id);
            $record->update([ 
                'nombreArea' => mb_strtoupper($this-> nombreArea, 'UTF-8'),
                'organizacion_id' => $this-> organizacion_id,
                //'user_create' => $this-> user_create,
                'user_update' => Auth::user()->id,
                'estado' => $this-> estado,
                'borrado' => $this-> borrado
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Area Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Area::where('id', $id);
            $record->delete([ 
				'user_update' => Auth::user()->id,
				'borrado' => 1
			]);
        }
    }
}
