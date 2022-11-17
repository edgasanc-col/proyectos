<?php

namespace Database\Factories;

use App\Models\Permiso;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PermisoFactory extends Factory
{
    protected $model = Permiso::class;

    public function definition()
    {
        return [
			'rol_id' => $this->faker->name,
			'modulo_id' => $this->faker->name,
			'crear' => $this->faker->name,
			'ver' => $this->faker->name,
			'editar' => $this->faker->name,
			'borrar' => $this->faker->name,
			'importar' => $this->faker->name,
			'exportar' => $this->faker->name,
			'user_create' => $this->faker->name,
			'user_update' => $this->faker->name,
			'estado' => $this->faker->name,
			'borrado' => $this->faker->name,
        ];
    }
}
