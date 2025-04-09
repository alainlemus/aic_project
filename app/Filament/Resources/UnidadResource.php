<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnidadResource\Pages;
use App\Models\Unidad;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Section;

class UnidadResource extends Resource
{
    protected static ?string $model = Unidad::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    protected static ?string $label = 'Unidades';

    protected static ?string $navigationGroup = 'Base de datos';

    protected static ?string $description = 'EN ESTE MODULO SE VEN TODOS LOS ELEMENTOS REGISTRADOS EN EL SISTEMA';

    protected static ?string $navigationBadgeTooltip = 'Número de unidades registrados';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Datos de la Unidad')
                ->description('Registra los datos de la unidad')
                    ->schema([
                        Forms\Components\TextInput::make('nombre')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('municipio_id')
                            ->label('Municipio')
                            ->relationship('municipio', 'nombre') // Relación con el modelo Municipio
                            ->searchable() // Habilita la búsqueda
                            ->preload() // Carga opciones iniciales
                            ->required(),
                            Forms\Components\TextInput::make('estado_de_fuerza')
                            ->label('Estado de Fuerza')
                            ->numeric()
                            ->required()
                            ->default(0),
                        Forms\Components\TextInput::make('vehiculos')
                            ->label('Vehículos')
                            ->numeric()
                            ->required()
                            ->default(0),
                        Forms\Components\Textarea::make('observaciones')
                            ->label('Observaciones')
                            ->maxLength(255)
                            ->rows(4) // Altura inicial en filas
                            ->autosize() // Ajusta la altura automáticamente según el contenido
                            ->nullable(), // Opcional, si permites que sea nulo
                        Forms\Components\Select::make('encargado_id')
                            ->label('Encargado de Unidad')
                            ->relationship(
                                name: 'encargado',
                                titleAttribute: 'nombre',
                                modifyQueryUsing: fn (Builder $query) => $query->where('status', 'ACTIVO')
                            ) // Relación con el modelo Elemento
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Nombre de la Unidad')
                    ->searchable(),
                Tables\Columns\TextColumn::make('municipio.nombre')
                    ->label('Municipio')
                    ->searchable(),
                Tables\Columns\TextColumn::make('vehiculos')
                    ->label('Numero de Vehículos')
                    ->searchable(),
                Tables\Columns\TextColumn::make('estado_de_fuerza')
                    ->label('Estado de Fuerza')
                    ->searchable(),
                Tables\Columns\TextColumn::make('encargado.nombre')
                    ->label('Ecargado de Unidad')
                    ->searchable(),
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Ninguna unidad registrada')
            ->emptyStateDescription('Cuando registres unidades, apareceran aqui.')
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
            'index' => Pages\ListUnidads::route('/'),
            'create' => Pages\CreateUnidad::route('/create'),
            'edit' => Pages\EditUnidad::route('/{record}/edit'),
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
