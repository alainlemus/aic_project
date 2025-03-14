<?php

namespace App\Filament\Resources\ElementoResource\Pages;

use App\Filament\Resources\ElementoResource;
use Filament\Actions;
use Filament\Notifications\Notification;
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

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index'); // Redirige al índice después de crear
    }

    // Personaliza el contenido de la notificación
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->title('Elemento editado!')
            ->body('El elemento se ha editado exitosamente.')
            ->success()
            ->seconds(5); // Duración en segundos antes de que desaparezca
    }
}
