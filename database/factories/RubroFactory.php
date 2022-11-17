<?php

namespace Database\Factories;

use App\Models\Rubro;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RubroFactory extends Factory
{
    protected $model = Rubro::class;

    public function definition()
    {
        return [
			'nombreRubro' => $this->faker->name,
			'codigoContable' => $this->faker->name,
			'variasFuentes' => $this->faker->name,
			'user_create' => $this->faker->name,
			'user_update' => $this->faker->name,
			'estado' => $this->faker->name,
			'borrado' => $this->faker->name,
        ];
    }
}
