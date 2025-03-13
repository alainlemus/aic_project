<?php

namespace App\Filament\Resources\TipoOrdenResource\Pages;

use App\Filament\Resources\TipoOrdenResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTipoOrden extends EditRecord
{
    protected static string $resource = TipoOrdenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
