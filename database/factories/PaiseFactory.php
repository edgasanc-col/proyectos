<?php

namespace Database\Factories;

use App\Models\Paise;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PaiseFactory extends Factory
{
    protected $model = Paise::class;

    public function definition()
    {
        return [
			'codigoPais' => $this->faker->name,
			'nombrePais' => $this->faker->name,
			'user_create' => $this->faker->name,
			'user_update' => $this->faker->name,
			'estado' => $this->faker->name,
			'borrado' => $this->faker->name,
        ];
    }
}
