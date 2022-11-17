<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividade extends Model
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'actividades';

    protected $fillable = [
        'nombreActividad',
        'producto',
        'valorTotalActividad',
        'ponderacion',
        'fecha_ejecucion',
        'fecha_limite',
        'fecha_realizacion',
        'empleado_id',
        'resultado_id',
        'user_create',
        'user_update',
        'estado',
        'borrado'
    ];
	
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividadRubros()
    {
        return $this->hasMany('App\Models\ActividadRubro', 'actividad_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function empleado()
    {
        return $this->hasOne('App\Models\Empleado', 'id', 'empleado_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function resultado()
    {
        return $this->hasOne('App\Models\Resultado', 'id', 'resultado_id');
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
