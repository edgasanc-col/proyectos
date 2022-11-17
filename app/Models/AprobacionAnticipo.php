<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AprobacionAnticipo extends Model
{
    use HasFactory;
	
    public $timestamps = true;

    protected $table = 'aprobacion_anticipos';

    protected $fillable = ['comentario','legalizado','anticipo_id','user_create','user_update','estado','borrado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function anticipos()
    {
        return $this->hasOne('App\Models\Anticipo', 'id', 'anticipo_id');
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
