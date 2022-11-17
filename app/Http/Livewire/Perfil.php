<?php

namespace App\Http\Livewire;

use Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;
use App\Models\User;

class Perfil extends Component
{
    use WithFileUploads;

    public $selected_id, $password, $password_confirmation, $img_user;

    public function render()
    {
        $user = DB::table('users as u')
            ->leftJoin('roles as r', 'u.rol_id', 'r.id')
            ->select('u.*', 'r.nombreRol')
            ->where('u.id', Auth::user()->id)
            ->first();

        $this->selected_id = $user->id;

        return view('livewire.perfil',[
            'user' =>$user,
        ]);
    }

    public function resetInput()
    {
        $this->password = null;
        $this->password_confirmation = null;
    }

    public function cancel()
    {
        $this->resetInput();
    }

    public function actualizar()
    {
        $this->validate([
            'password' => 'required|confirmed|min:6',
            'selected_id' => 'required|numeric'
        ]);

        if ($this->selected_id) {
			$record = User::find($this->selected_id);
            $record->password = Hash::make($this->password);
            $record->save();

            $this->resetInput();

			session()->flash('message_actualizar', 'Contraseña actualizada correctamente');
        }
    }

    public function upload()
    {
        $this->validate([
            'img_user' => 'image|max:1024', // 1MB Max
            'selected_id' => 'required|numeric'
        ]);

        if ($this->selected_id) {
            $img_user = sha1($this->img_user->getClientOriginalName().date('Y-m-d h:i:s')).'.'.$this->img_user->getClientOriginalExtension();
    
            $this->img_user->storeAs('public/profile-photos', $img_user);

            $record = User::find($this->selected_id);
            $record->update([ 
                    'img_user' => $img_user
                   ]); 

            session()->flash('message_upload', 'Imagen perfil actualizada correctamente');
        }
    }
}
