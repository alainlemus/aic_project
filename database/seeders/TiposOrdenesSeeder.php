<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoOrden;
use Carbon\Carbon;

class TiposOrdenesSeeder extends Seeder
{
    public function run(): void
    {
        $tiposOrdenes = [
            ['nombre' => 'Orden de aprehensión'],
            ['nombre' => 'Orden de comparecencia'],
            ['nombre' => 'Orden de presentación'],
            ['nombre' => 'Requerimientos'],
            ['nombre' => 'Medidas de protección'],
            ['nombre' => 'Oficios de investigación'],
        ];

        foreach ($tiposOrdenes as $tipo) {
            TipoOrden::create([
                'nombre' => $tipo['nombre'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}