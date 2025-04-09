<?php

namespace Database\Factories;

use App\Models\Elemento;
use App\Models\Unidad;
use App\Models\Municipio;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnidadFactory extends Factory
{
    protected $model = Unidad::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->company,
            'municipio_id' => Municipio::inRandomOrder()->first()->id,
            'observaciones' => $this->faker->sentence, // Genera una oración aleatoria para observaciones
            'estado_de_fuerza' => $this->faker->numberBetween(10, 100), // Genera un número aleatorio para estado de fuerza
            'vehiculos' => $this->faker->numberBetween(1, 20), // Genera un número aleatorio para vehículos
            'encargado_id' => Elemento::inRandomOrder()->first()->id ?? null, // Selecciona un encargado aleatorio o null si no hay elementos
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}