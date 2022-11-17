<?php

namespace Database\Factories;

use App\Models\Avance;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AvanceFactory extends Factory
{
    protected $model = Avance::class;

    public function definition()
    {
        return [
			'rubro_id' => $this->faker->name,
			'descripcion' => $this->faker->name,
			'valorAsignado' => $this->faker->name,
			'valorAnticipo' => $this->faker->name,
			'legalizado' => $this->faker->name,
			'empleado_id' => $this->faker->name,
			'actividad_id' => $this->faker->name,
			'user_create' => $this->faker->name,
			'user_update' => $this->faker->name,
			'estado' => $this->faker->name,
			'borrado' => $this->faker->name,
        ];
    }
}
