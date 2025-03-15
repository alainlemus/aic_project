<?php

namespace App\Filament\Widgets;

use App\Models\Orden;
use App\Models\Elemento;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class OrdenesPorEstadoChart extends ChartWidget
{
    protected static ?string $heading = 'Ordenes por elemento';

    // Filtros disponibles
    protected function getFilters(): ?array
    {
        $elementos = Elemento::all()->mapWithKeys(function ($elemento) {
            $nombreCompleto = trim("{$elemento->nombre} {$elemento->apellido_paterno} {$elemento->apellido_materno}");
            return [$elemento->id => $nombreCompleto];
        })->toArray();

        return $elementos;

    }

    protected function getData(): array
    {

        $filters = $this->getFilters();

        // Consulta base
        $query = Orden::query();

        // Filtro por elemento
        if (!empty($filters)) {
            $query->where('elemento_id',  $this->filter);
        }

        // Agrupar por estado y contar
        $data = $query->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

            return [
                'datasets' => [
                    [
                        'label' => 'Órdenes por Status',
                        'data' => array_values($data),
                        'backgroundColor' => [
                            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                        ], // Colores para cada barra
                    ],
                ],
                'labels' => array_keys($data),
            ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}