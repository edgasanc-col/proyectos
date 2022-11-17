<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
			'nombres' => $this->faker->name,
			'apellidos' => $this->faker->name,
			'tipo_doc' => $this->faker->name,
			'cedula' => $this->faker->name,
			'email' => $this->faker->name,
			'img_user' => $this->faker->name,
			'estado' => $this->faker->name,
			'borrado' => $this->faker->name,
        ];
    }
}
