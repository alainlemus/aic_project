<?php

namespace Database\Factories;

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
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}