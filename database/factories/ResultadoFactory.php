<?php

namespace Database\Factories;

use App\Models\Resultado;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ResultadoFactory extends Factory
{
    protected $model = Resultado::class;

    public function definition()
    {
        return [
			'nombreResultado' => $this->faker->name,
			'nombreIndicador' => $this->faker->name,
			'proyecto_id' => $this->faker->name,
			'user_create' => $this->faker->name,
			'user_update' => $this->faker->name,
			'estado' => $this->faker->name,
			'borrado' => $this->faker->name,
        ];
    }
}
