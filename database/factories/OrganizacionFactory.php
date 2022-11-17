<?php

namespace Database\Factories;

use App\Models\Organizacion;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrganizacionFactory extends Factory
{
    protected $model = Organizacion::class;

    public function definition()
    {
        return [
			'nit' => $this->faker->name,
			'nombreOrganizacion' => $this->faker->name,
			'user_create' => $this->faker->name,
			'user_update' => $this->faker->name,
			'estado' => $this->faker->name,
			'borrado' => $this->faker->name,
        ];
    }
}
