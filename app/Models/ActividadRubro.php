<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActividadRubro extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'actividad_rubros';

    protected $fillable = ['rubro_id', 'valorUnitario', 'cantidad', 'valorTotal', 'actividad_id','user_create','user_update','estado','borrado'];
}
