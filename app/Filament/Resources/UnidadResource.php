<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnidadResource\Pages;
use App\Filament\Resources\UnidadResource\RelationManagers;
use App\Models\Elemento;
use App\Models\Unidad;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UnidadResource extends Resource
{
    protected static ?string $model = Unidad::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    protected static ?string $label = 'Unidades';

    protected static ?string $navigationGroup = 'Elementos';

    protected static ?string $description = 'EN ESTE MODULO SE VEN TODOS LOS ELEMENTOS REGISTRADOS EN EL SISTEMA';

    protected static ?string $navigationBadgeTooltip = 'Número de unidades registrados';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('elemento_id')
                    ->label('Elemento')
                    ->relationship('elemento', 'nombre') // Relación con el modelo Elemento
                    ->searchable() // Habilita la búsqueda
                    ->preload() // Carga opciones iniciales
                    ->required()
                    ->getOptionLabelFromRecordUsing(fn (Elemento $record) => "{$record->nombre} {$record->apellido_paterno} {$record->apellido_materno} - {$record->no_empleado}"),
                Forms\Components\Select::make('municipio_id')
                    ->label('Municipio')
                    ->relationship('municipio', 'nombre') // Relación con el modelo Municipio
                    ->searchable() // Habilita la búsqueda
                    ->preload() // Carga opciones iniciales
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('municipio.nombre')
                    ->searchable(),
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
