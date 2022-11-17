<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyectoPresupuesto extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'proyecto_presupuestos';

    protected $fillable = ['valorMonedaLocal','valorMonedaExtranjera','donante_id','proyecto_id','user_create','user_update','estado','borrado'];
}
