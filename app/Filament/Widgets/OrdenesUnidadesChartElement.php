<?php

namespace App\Filament\Widgets;

use App\Models\Unidad;
use App\Models\Orden;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class OrdenesUnidadesChartElement extends ApexChartWidget
{
    //protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 3;
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'ordenesUnidadesChartElement';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Ordenes por Unidad: Se muestran las ordenes por status filtrando por unidad y rango de fechas';
    //protected static ?string $subheading = 'Se muestran las ordenes por status filtrando por unidad y rango de fechas';

    //protected static ?string $footer = 'Ordenes por status, segun el filtro.';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $unidad = $this->filterFormData['unidad_id'] ?? null;
        $dateStart = $this->filterFormData['date_start'] ?? now()->subMonth();
        $dateEnd = $this->filterFormData['date_end'] ?? now();

        $data = Orden::whereBetween('created_at', [$dateStart, $dateEnd])
        ->when($unidad, function ($query) use ($unidad) {
            $query->whereHas('elemento', function ($query) use ($unidad) {
                $query->where('id_unidad', $unidad);
            });
        })
        ->selectRaw('status, COUNT(*) as count')
        ->groupBy('status')
        ->get();


        //\Illuminate\Support\Facades\Log::info("Seleccion de filtros, unidad: {$unidad},  fecha inicio: " . $dateStart . ', fecha fin: ' . $dateEnd . ' , datos: ' . $data);

        // Definir los posibles estados
        $statuses = ['RECIBIDO', 'CUMPLIDO', 'INFORMADO', 'CANCELADO', 'PENDIENTE'];

        // Mapear los resultados a los estados definidos, asegurando que todos los estados estén presentes
        $chartData = collect($statuses)->map(fn($status) => $data->firstWhere('status', $status)->count ?? 0);

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 276,
            ],
            'series' => [
                [
                    'name' => 'BasicBarChart',
                    'data' => $chartData,
                ],
            ],
            'xaxis' => [
                'categories' => ['RECIBIDO','CUMPLIDO','INFORMADO','CANCELADO','PENDIENTE'],
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 5,
                    'horizontal' => false,
                ],
            ],
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            Select::make('unidad_id')
                ->label('Unidad')
                ->options(Unidad::all()->mapWithKeys(function ($item) {
                    return [
                        $item->id => "{$item->nombre}"
                    ];
                }))
                ->searchable() // Habilita la búsqueda
                ->preload(), // Carga opciones iniciales
            DatePicker::make('date_start')
                ->label('Fecha inicio')
                ->default(now()->subMonth()),
            DatePicker::make('date_end')
                ->label('Fecha fin')
                ->default(now()),
        ];
    }
}
