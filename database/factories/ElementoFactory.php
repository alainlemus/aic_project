<?php

namespace Database\Factories;

use App\Models\Elemento;
use App\Models\Unidad;
use Illuminate\Database\Eloquent\Factories\Factory;

class ElementoFactory extends Factory
{
    protected $model = Elemento::class;

    public function definition(): array
    {
        return [
            'no_empleado' => $this->faker->unique()->numerify('EMP#####'),
            'cargo' => $this->faker->randomElement(['Agente', 'Comandante', 'Analista']),
            'apellido_paterno' => $this->faker->lastName,
            'apellido_materno' => $this->faker->lastName,
            'nombre' => $this->faker->firstName,
            'id_unidad' => Unidad::factory(), // Relaciona con una unidad existente o creada
            'observaciones' => $this->faker->optional()->sentence,
            'status' => $this->faker->randomElement(['ACTIVO', 'INACTIVO']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}