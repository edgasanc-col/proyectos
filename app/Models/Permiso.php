<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'permisos';

    protected $fillable = ['rol_id','modulo_id','crear','ver','editar','borrar','importar','exportar','user_create','user_update','estado','borrado'];
	
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function modulo()
    {
        return $this->hasOne('App\Models\Modulo', 'id', 'modulo_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function role()
    {
        return $this->hasOne('App\Models\Role', 'id', 'rol_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user_create()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_create');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user_update()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_update');
    }
    
}
