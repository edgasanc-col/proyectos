<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anticipo extends Model
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'anticipos';

    protected $fillable = ['valorAnticipo','nit','razon_social','descripcion','legalizado','avance_id','user_create','user_update','estado','borrado'];
	
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function avance()
    {
        return $this->hasOne('App\Models\Avance', 'id', 'avance_id');
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
