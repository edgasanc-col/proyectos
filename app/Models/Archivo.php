<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'archivos';

    protected $fillable = ['observacion','archivo','avance_id','user_create','user_update','updated_at','estado','borrado'];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function avances()
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