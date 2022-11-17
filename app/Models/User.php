<?php 

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable;
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'users';

    protected $fillable = ['nombres','apellidos','tipo_doc','cedula','email', 'password','img_user', 'rol_id','estado','borrado'];
	
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function departamentos_create()
    {
        return $this->hasMany('App\Models\Departamento', 'user_create', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function departamentos_update()
    {
        return $this->hasMany('App\Models\Departamento', 'user_update', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function modulos_update()
    {
        return $this->hasMany('App\Models\Modulo', 'user_update', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function modulos_create()
    {
        return $this->hasMany('App\Models\Modulo', 'user_create', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function municipios_create()
    {
        return $this->hasMany('App\Models\Municipio', 'user_create', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function municipios_update()
    {
        return $this->hasMany('App\Models\Municipio', 'user_update', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paises_create()
    {
        return $this->hasMany('App\Models\Paise', 'user_create', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paises_update()
    {
        return $this->hasMany('App\Models\Paise', 'user_update', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permisos_create()
    {
        return $this->hasMany('App\Models\Permiso', 'user_create', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permisos_update()
    {
        return $this->hasMany('App\Models\Permiso', 'user_update', 'id');
    }
    
}
