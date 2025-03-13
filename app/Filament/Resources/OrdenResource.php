<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrdenResource\Pages;
use App\Http\Livewire\PdfViewer;
use App\Models\Elemento;
use App\Models\Orden;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Actions\StaticAction;
use Filament\Support\Enums\MaxWidth;
use Filament\Infolists\Components\Livewire;

class OrdenResource extends Resource
{
    protected static ?string $model = Orden::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $label = 'Ordenes';

    protected static ?string $navigationGroup = 'Ordenes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'RECIBIDO' => 'Recibido',
                        'CUMPLIDO' => 'Cumplido',
                        'INFORMADO' => 'Informado',
                        'CANCELADO' => 'Cancelado',
                        'PENDIENTE' => 'Pendiente',
                    ])
                    ->default('RECIBIDO') // Valor por defecto
                    ->required(),
                Forms\Components\Select::make('tipo_orden_id')
                    ->label('Tipo de orden')
                    ->relationship('tipoOrden', 'nombre') // Relación con el modelo tipoOrden
                    ->searchable() // Habilita la búsqueda
                    ->preload() // Carga opciones iniciales
                    ->required(),
                Forms\Components\Select::make('elemento_id')
                    ->label('Elemento')
                    ->relationship('elemento', 'nombre') // Relación con el modelo Elemento
                    ->searchable() // Habilita la búsqueda
                    ->preload() // Carga opciones iniciales
                    ->required()
                    ->getOptionLabelFromRecordUsing(fn (Elemento $record) => "{$record->nombre} {$record->apellido_paterno} {$record->apellido_materno} - {$record->no_empleado}"), // Combina nombre y apellido_paterno
                Forms\Components\FileUpload::make('archivos')
                    ->label('Archivos PDF')
                    ->multiple() // Permite múltiples archivos
                    ->acceptedFileTypes(['application/pdf']) // Solo PDFs
                    ->maxFiles(20) // Máximo 20 archivos
                    ->maxSize(5120) // Máximo 5 MB (5120 KB)
                    ->directory('temp') // Carpeta en public/archivos
                    ->preserveFilenames() // Conserva nombres originales
                    ->required(false) // Opcional, cambia a true si es obligatorio
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        // Aquí manejarás el guardado en la tabla archivos después de crear la orden
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('tipoOrden.nombre')
                    ->label('Tipo de Orden')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('elemento.nombre')
                    ->label('Elemento')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn (string $state, Orden $record) => "{$record->elemento->nombre} {$record->elemento->apellido_paterno}"),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Action::make('view_pdf')
                    ->label('Ver Archivos')
                    ->icon('heroicon-o-eye')
                    ->color('success')
                    ->modalHeading('Archivos PDF')
                    ->modalWidth(MaxWidth::FiveExtraLarge)
                    ->modalSubmitAction(false)
                    ->modalCancelAction(fn (StaticAction $action) => $action->label('Cerrar'))
                    ->modalContent(function (array $arguments) {
                        $archivos = $arguments['archivos'] ?? [];
                        return Livewire::make(PdfViewer::class, ['archivos' => $archivos])->lazy();
                    }),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);

    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrdens::route('/'),
            'create' => Pages\CreateOrden::route('/create'),
            'edit' => Pages\EditOrden::route('/{record}/edit'),
        ];
    }
}
