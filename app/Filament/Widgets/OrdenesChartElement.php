<?php

namespace App\Filament\Widgets;

use App\Models\Elemento;
use App\Models\Orden;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class OrdenesChartElement extends ApexChartWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'ordenesChartElement';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Ordenes';

    protected static ?string $footer = 'Ordenes por status, segun el filtro.';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        //dd($this->filterFormData);
        $elemento = $this->filterFormData['elemento_id'];
        $dateStart = $this->filterFormData['date_start'];
        $dateEnd = $this->filterFormData['date_end'];

        $data = Orden::whereBetween('created_at', [
            $this->filterFormData['date_start'] ?? now()->subMonth(),
            $this->filterFormData['date_end'] ?? now()
        ])
        ->when($this->filterFormData['elemento_id'] ?? null, fn($query, $elemento) =>
            $query->where('elemento_id', $elemento)
        )
        ->selectRaw('status, COUNT(*) as count')
        ->groupBy('status')
        ->get();

        //dd($data,$elemento);
        //dd(now());
        \Illuminate\Support\Facades\Log::info("Seleccion de filtros, elemento: {$elemento},  fecha inicio: " . $dateStart . ', fecha fin: ' . $dateEnd . ' , datos: ' . $data);

        // Definir los posibles estados
        $statuses = ['RECIBIDO', 'CUMPLIDO', 'INFORMADO', 'CANCELADO', 'PENDIENTE'];

        // Mapear los resultados a los estados definidos, asegurando que todos los estados estén presentes
        $chartData = collect($statuses)->map(fn($status) => $data->firstWhere('status', $status)->count ?? 0);

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
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
            'colors' => ['#f59e0b'],
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 3,
                    'horizontal' => false,
                ],
            ],
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            Select::make('elemento_id')
                ->label('Elemento')
                ->options(Elemento::all()->mapWithKeys(function ($item) {
                    return [
                        $item->id => "{$item->nombre} {$item->apellido_paterno} {$item->apellido_materno}"
                    ];
                }))
                ->searchable() // Habilita la búsqueda
                ->preload(), // Carga opciones iniciales
            DatePicker::make('date_start')
                ->default(now()->subMonth()),
            DatePicker::make('date_end')
                ->default(now()),
        ];
    }
}
