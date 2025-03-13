<?php

namespace App\Filament\Resources\ElementoResource\Pages;

use App\Filament\Resources\ElementoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListElementos extends ListRecords
{
    protected static string $resource = ElementoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Agregar Elemento'),
        ];
    }
}
