<?php

namespace App\Filament\Resources\MunicipioResource\Pages;

use App\Filament\Resources\MunicipioResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditMunicipio extends EditRecord
{
    protected static string $resource = MunicipioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index'); // Redirige al índice después de crear
    }

    // Personaliza el contenido de la notificación
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->title('Municipio editado!')
            ->body('El municipio se ha editado exitosamente.')
            ->success()
            ->seconds(5); // Duración en segundos antes de que desaparezca
    }
}
