<?php

namespace App\Filament\Resources\OrdenResource\Pages;

use App\Filament\Resources\OrdenResource;
use App\Models\Orden;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class CreateOrden extends CreateRecord
{
    protected static string $resource = OrdenResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        if (isset($data['archivos']) && !empty($data['archivos'])) {
            $archivosProcesados = [];
            $originalFilenames = $data['original_filenames'] ?? [];

            foreach ($data['archivos'] as $index => $file) {
                $tempPath = $file; // temp/UUID.pdf
                $originalName = $originalFilenames[$index] ?? basename($file);

                if (!Storage::disk('public')->exists($tempPath)) {
                    Notification::make()
                        ->title('Error al subir archivo')
                        ->body("No se pudo encontrar el archivo '{$originalName}' en el servidor.")
                        ->danger()
                        ->send();

                    $this->halt(); // Detiene el proceso de creación
                }

                if (Storage::disk('public')->size($tempPath) > 5 * 1024 * 1024) {
                    Notification::make()
                        ->title('Archivo demasiado grande')
                        ->body("El archivo '{$originalName}' excede el límite de 5 MB.")
                        ->danger()
                        ->send();

                    $this->halt();
                }

                $mimeType = null;
                try {
                    $mimeType = File::mimeType(Storage::disk('public')->path($tempPath));
                } catch (\Exception $e) {
                    Notification::make()
                        ->title('Error de validación')
                        ->body("No se pudo verificar el tipo de archivo '{$originalName}': " . $e->getMessage())
                        ->danger()
                        ->send();

                    $this->halt();
                }

                if ($mimeType !== 'application/pdf') {
                    Notification::make()
                        ->title('Formato no válido')
                        ->body("El archivo '{$originalName}' no es un PDF (detectado: $mimeType).")
                        ->danger()
                        ->send();

                    $this->halt();
                }

                $archivosProcesados[] = ['temp_path' => $file, 'original_name' => $originalName];
            }

            if (count($archivosProcesados) > 20) {
                throw new \Exception('No puedes subir más de 20 archivos.');
            }

            $data['archivos_procesados'] = $archivosProcesados;
        }

        return $data;

    }

    protected function handleRecordCreation(array $data): Orden
    {
        $ordenData = array_diff_key($data, array_flip(['archivos', 'archivos_procesados', 'original_filenames']));
        $orden = static::getModel()::create($ordenData);

        if (isset($data['archivos_procesados']) && !empty($data['archivos_procesados'])) {
            foreach ($data['archivos_procesados'] as $archivo) {
                $tempPath = $archivo['temp_path'];
                $originalName = $archivo['original_name'];
                $finalPath = 'archivos/' . $originalName;

                Storage::disk('public')->move($tempPath, $finalPath);

                $orden->archivos()->create([
                    'nombre' => $originalName,
                    'url' => $finalPath,
                ]);
            }
        }

        return $orden;
    }

    protected function afterCreate(): void
    {
        if (Storage::disk('public')->exists('temp')) {
            Storage::disk('public')->deleteDirectory('temp');
        }
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index'); // Redirige al índice después de crear
    }

    // Personaliza el contenido de la notificación
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->title('¡Orden registrada!')
            ->body('La orden se ha creado exitosamente.')
            ->success()
            ->seconds(5); // Duración en segundos antes de que desaparezca
    }

}
