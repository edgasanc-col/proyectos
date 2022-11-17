<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'roles';

    protected $fillable = ['nombreRol','user_create','user_update','estado','borrado'];
	
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permisos()
    {
        return $this->hasMany('App\Models\Permiso', 'rol_id', 'id');
    }
    
}
