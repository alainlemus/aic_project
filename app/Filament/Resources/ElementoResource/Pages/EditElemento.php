<?php

namespace App\Filament\Resources\ElementoResource\Pages;

use App\Filament\Resources\ElementoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditElemento extends EditRecord
{
    protected static string $resource = ElementoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
