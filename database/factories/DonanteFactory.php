<?php

namespace Database\Factories;

use App\Models\Donante;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DonanteFactory extends Factory
{
    protected $model = Donante::class;

    public function definition()
    {
        return [
			'nombreDonante' => $this->faker->name,
			'user_create' => $this->faker->name,
			'user_update' => $this->faker->name,
			'estado' => $this->faker->name,
			'borrado' => $this->faker->name,
        ];
    }
}
