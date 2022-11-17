<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Paise;

class Paises extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $codigoPais, $nombrePais, $user_create, $user_update, $estado, $borrado;
    public $updateMode = false;

    public function render()
    {
        $mdl = 5;
        include('Include/permisos.php');

        if($ver == 0) {
			return view('error');
		}
        else {
            $keyWord = '%'.$this->keyWord .'%';
            return view('livewire.paises.view', [
                'paises' => DB::table('paises as pa')
                            ->leftJoin('users as uc', 'pa.user_create', 'uc.id')
                            ->leftJoin('users as uu', 'pa.user_update', 'uu.id')
                            ->select('pa.*', 'uc.nombres as ucnombres', 'uc.apellidos as ucapellidos', 'uu.nombres as uunombres', 'uu.apellidos as uuapellidos')
                            ->orWhere('pa.codigoPais', 'LIKE', $keyWord)
                            ->orWhere('pa.nombrePais', 'LIKE', $keyWord)
                            ->orWhere('uc.nombres', 'LIKE', $keyWord)
                            ->orWhere('uc.apellidos', 'LIKE', $keyWord)
                            ->orWhere('uu.nombres', 'LIKE', $keyWord)
                            ->orWhere('uu.apellidos', 'LIKE', $keyWord)
                            ->orderBy('pa.id', 'DESC')
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
		$this->codigoPais = null;
		$this->nombrePais = null;
		$this->user_create = null;
		$this->user_update = null;
		$this->estado = null;
		$this->borrado = null;
    }

    public function store()
    {
        $this->validate([
            'codigoPais' => 'required',
            'nombrePais' => 'required',
        ]);
        
        Paise::create([ 
			'codigoPais' => $this-> codigoPais,
			'nombrePais' => mb_strtoupper($this-> nombrePais, 'UTF-8'),
			'user_create' => Auth::user()->id,
			'user_update' => null,
            'updated_at' => null,
			'estado' => 1,
			'borrado' => 0
        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Paise Successfully created.');
    }

    public function edit($id)
    {
        $record = Paise::findOrFail($id);

        $this->selected_id = $id; 
		$this->codigoPais = $record-> codigoPais;
		$this->nombrePais = $record-> nombrePais;
		$this->user_create = $record-> user_create;
		$this->user_update = $record-> user_update;
		$this->estado = $record-> estado;
		$this->borrado = $record-> borrado;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
            'codigoPais' => 'required',
            'nombrePais' => 'required',
            'user_create' => 'required',
            'estado' => 'required',
            'borrado' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Paise::find($this->selected_id);
            $record->update([ 
                'codigoPais' => $this-> codigoPais,
                'nombrePais' => $this-> mb_strtoupper($this-> nombrePais, 'UTF-8'),
                'user_create' => $this-> user_create,
                'user_update' => Auth::user()->id,
                'estado' => $this-> estado,
                'borrado' => $this-> borrado
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Paise Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Paise::where('id', $id);
            $record->delete([
                'user_update' => Auth::user()->id,
                'borrado' => 1
                ]);
        }
    }
}
