<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrdenResource\Pages;
use App\Http\Livewire\PdfViewer;
use App\Models\Archivo;
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
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Section;

class OrdenResource extends Resource
{
    protected static ?string $model = Orden::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $label = 'Ordenes';

    protected static ?string $navigationGroup = 'Ordenes';

    protected static ?string $navigationBadgeTooltip = 'Número de ordenes registrados';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Datos de la Orden')
                ->description('Registra los datos de la orden')
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
                            ->relationship(
                                name: 'elemento',
                                titleAttribute: 'nombre',
                                modifyQueryUsing: fn (Builder $query) => $query->where('status', 'ACTIVO')
                            ) // Relación con el modelo Elemento
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
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->query(Orden::with('archivos')) // Carga ansiosa de la relación archivos
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable(),
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
                    ->formatStateUsing(fn (Orden $record) => "{$record->elemento->nombre} {$record->elemento->apellido_paterno} {$record->elemento->apellido_materno}"),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de Registro')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Fecha de Actualización')
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
                    ->label(false) // Oculta el botón en la tabla
                    ->modalHeading('Visualizar PDF')
                    ->modalContent(function (array $arguments) {
                        $ruta = $arguments['url'] ?? '';
                        \Illuminate\Support\Facades\Log::info("Abriendo modal con ruta: {$ruta}");
                        return view('filament.modals.pdf-viewer', ['ruta' => $ruta]);
                    })
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Cerrar'),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Ninguna orden registrada')
            ->emptyStateDescription('Cuando registres las ordenes, apareceran aqui.')
            ->emptyStateIcon('heroicon-o-bookmark');

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

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'info';
    }
}
