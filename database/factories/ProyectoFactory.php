<?php

namespace Database\Factories;

use App\Models\Proyecto;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProyectoFactory extends Factory
{
    protected $model = Proyecto::class;

    public function definition()
    {
        return [
			'nombreProyecto' => $this->faker->name,
			'fechaInicio' => $this->faker->name,
			'fechaFin' => $this->faker->name,
			'porcentajeDesviacion' => $this->faker->name,
			'area_id' => $this->faker->name,
			'user_create' => $this->faker->name,
			'user_update' => $this->faker->name,
			'estado' => $this->faker->name,
			'borrado' => $this->faker->name,
        ];
    }
}
