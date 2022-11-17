<?php

namespace Database\Factories;

use App\Models\Anticipo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AnticipoFactory extends Factory
{
    protected $model = Anticipo::class;

    public function definition()
    {
        return [
			'valorAnticipo' => $this->faker->name,
			'descripcion' => $this->faker->name,
			'legalizado' => $this->faker->name,
			'avance_id' => $this->faker->name,
			'user_create' => $this->faker->name,
			'user_update' => $this->faker->name,
			'estado' => $this->faker->name,
			'borrado' => $this->faker->name,
        ];
    }
}
