<?php

namespace App\Filament\Resources\TipoOrdenResource\Pages;

use App\Filament\Resources\TipoOrdenResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateTipoOrden extends CreateRecord
{
    protected static string $resource = TipoOrdenResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index'); // Redirige al índice después de crear
    }

    // Personaliza el contenido de la notificación
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->title('¡Elemento registrado!')
            ->body('El tipo de orden se ha creado exitosamente.')
            ->success()
            ->seconds(5); // Duración en segundos antes de que desaparezca
    }
}
