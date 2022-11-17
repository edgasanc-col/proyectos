<?php

namespace Database\Factories;

use App\Models\Actividade;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ActividadeFactory extends Factory
{
    protected $model = Actividade::class;

    public function definition()
    {
        return [
			'nombreActividad' => $this->faker->name,
			'valorUnitario' => $this->faker->name,
			'cantidad' => $this->faker->name,
			'valorTotal' => $this->faker->name,
			'ponderacion' => $this->faker->name,
			'empleado_id' => $this->faker->name,
			'resultado_id' => $this->faker->name,
			'user_create' => $this->faker->name,
			'user_update' => $this->faker->name,
			'estado' => $this->faker->name,
			'borrado' => $this->faker->name,
        ];
    }
}
