<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultadoUser extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'resultado_users';

    protected $fillable = ['empleado_id','resultado_id','user_create','user_update','estado','borrado'];
}