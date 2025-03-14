<?php

namespace App\Filament\Resources\UnidadResource\Pages;

use App\Filament\Resources\UnidadResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateUnidad extends CreateRecord
{
    protected static string $resource = UnidadResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index'); // Redirige al índice después de crear
    }

    // Personaliza el contenido de la notificación
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->title('Unidad registrada!')
            ->body('La unidad se ha creado exitosamente.')
            ->success()
            ->seconds(5); // Duración en segundos antes de que desaparezca
    }
}
