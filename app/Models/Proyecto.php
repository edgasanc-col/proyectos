<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'proyectos';

    protected $fillable = ['nombreProyecto', 'valorTotalProyecto', 'valorTRM','fechaInicio','fechaFin','porcentajeDesviacion','area_id','user_create','user_update','estado','borrado'];
	
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function area()
    {
        return $this->hasOne('App\Models\Area', 'id', 'area_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proyectoPresupuestos()
    {
        return $this->hasMany('App\Models\ProyectoPresupuesto', 'proyecto_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user_update()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_update');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user_create()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_create');
    }
    
}
