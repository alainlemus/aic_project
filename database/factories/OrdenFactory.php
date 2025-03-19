<?php

namespace Database\Factories;

use App\Models\Elemento;
use App\Models\Orden;
use App\Models\TipoOrden;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orden>
 */
class OrdenFactory extends Factory
{
    protected $model = Orden::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->company,
            'status' => $this->faker->randomElement(['RECIBIDO', 'CUMPLIDO', 'INFORMADO', 'CANCELADO', 'PENDIENTE']),
            'tipo_orden_id' => TipoOrden::inRandomOrder()->first()->id,
            'elemento_id' => Elemento::inRandomOrder()->first()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
