<?php

namespace App\Filament\Widgets;

use App\Models\Orden;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected ?string $heading = 'Estadisticas Generales';
    protected ?string $description = 'En las tarjetas se muestra información de las ordenes y su status.';

    protected static bool $isLazy = true;
    protected static ?string $pollingInterval =  '15s';

    protected function getStats(): array
    {
        $total = Orden::all()->count();
        $recibido = Orden::where('status','RECIBIDO')->count();
        $cumplido = Orden::where('status','CUMPLIDO')->count();
        $informado = Orden::where('status','INFORMADO')->count();
        $cancelado = Orden::where('status','CANCELADO')->count();
        $pendiente = Orden::where('status','PENDIENTE')->count();

        return [
            Stat::make('Número total de Ordenes', $total)
                ->icon('heroicon-o-wallet', IconPosition::Before)
                ->color('success'),
            Stat::make('Ordenes Recibidas',  $recibido)
                ->icon('heroicon-o-rectangle-stack', IconPosition::Before),
            Stat::make('Ordenes Cumplidas',  $cumplido)
                ->icon('heroicon-o-check-circle', IconPosition::Before),
            Stat::make('Ordenes Informadas',  $informado)
                ->icon('heroicon-o-identification', IconPosition::Before),
            Stat::make('Ordenes Canceladas',  $cancelado)
                ->icon('heroicon-o-x-circle', IconPosition::Before),
            Stat::make('Ordenes Pendientes',  $pendiente)
                ->icon('heroicon-o-receipt-refund', IconPosition::Before),
        ];
    }
}
