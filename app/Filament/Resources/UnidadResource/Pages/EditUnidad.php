<?php

namespace App\Filament\Resources\UnidadResource\Pages;

use App\Filament\Resources\UnidadResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditUnidad extends EditRecord
{
    protected static string $resource = UnidadResource::class;

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
            ->title('Unidad editada!')
            ->body('La unidad se ha editado exitosamente.')
            ->success()
            ->seconds(5); // Duración en segundos antes de que desaparezca
    }
}
