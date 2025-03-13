<?php

namespace App\Filament\Resources\TipoOrdenResource\Pages;

use App\Filament\Resources\TipoOrdenResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTipoOrdens extends ListRecords
{
    protected static string $resource = TipoOrdenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Agregar Tipo de Orden'),
        ];
    }
}
