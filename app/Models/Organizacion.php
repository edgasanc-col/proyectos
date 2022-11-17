<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organizacion extends Model
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'organizacions';

    protected $fillable = ['nit','nombreOrganizacion','user_create','user_update','estado','borrado'];
	
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function areas()
    {
        return $this->hasMany('App\Models\Area', 'organizacion_id', 'id');
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
