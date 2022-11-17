<?php

namespace Database\Factories;

use App\Models\Modulo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ModuloFactory extends Factory
{
    protected $model = Modulo::class;

    public function definition()
    {
        return [
			'nombreModulo' => $this->faker->name,
			'user_create' => $this->faker->name,
			'user_update' => $this->faker->name,
			'estado' => $this->faker->name,
			'borrado' => $this->faker->name,
        ];
    }
}
