<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ElementoResource\Pages;
use App\Filament\Resources\ElementoResource\RelationManagers;
use App\Models\Elemento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ElementoResource extends Resource
{
    protected static ?string $model = Elemento::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $label = 'Elementos';

    protected static ?string $navigationGroup = 'Elementos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('no_empleado')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cargo')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('apellido_paterno')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('apellido_materno')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('id_unidad')
                    ->label('Unidad')
                    ->relationship('unidad', 'nombre') // Relación con el modelo Municipio
                    ->searchable() // Habilita la búsqueda
                    ->preload() // Carga opciones iniciales
                    ->required(),
                Forms\Components\Textarea::make('observaciones')
                    ->label('Observaciones')
                    ->maxLength(255)
                    ->rows(4) // Altura inicial en filas
                    ->autosize() // Ajusta la altura automáticamente según el contenido
                    ->nullable(), // Opcional, si permites que sea nulo
                Forms\Components\Toggle::make('status')
                    ->inline(true)
                    ->label('Status')
                    ->onColor('success') // Verde cuando está activo
                    ->offColor('danger') // Rojo cuando está inactivo
                    ->default(true)
                    ->onIcon('heroicon-s-check') // Icono de check cuando está activo
                    ->offIcon('heroicon-s-x-mark') // Icono de X cuando está inactivo
                    ->afterStateHydrated(function ($state, callable $set, $record) {
                        if ($record) {
                            $set('status', $record->status === 'ACTIVO');
                        }
                    })
                    ->required(), // Convierte true/false a ENUM
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([
                Tables\Columns\TextColumn::make('no_empleado')
                    ->badge()
                    ->color('info')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cargo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nombre')
                        ->searchable(),
                Tables\Columns\TextColumn::make('apellido_paterno')
                    ->searchable(),
                Tables\Columns\TextColumn::make('apellido_materno')
                    ->searchable(),
                Tables\Columns\TextColumn::make('unidad.nombre')
                    ->label('Unidad')
                    ->sortable()
                    ->searchable(),
                /*Tables\Columns\TextColumn::make('observaciones')
                    ->searchable(),*/
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ACTIVO' => 'success',
                        'INACTIVO' => 'danger',
                    })
                    ->extraAttributes(['class' => 'font-bold']),
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
            ->emptyStateHeading('Ningun elemento registrado')
            ->emptyStateDescription('Cuando registres elementos, apareceran aqui.')
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
            'index' => Pages\ListElementos::route('/'),
            'create' => Pages\CreateElemento::route('/create'),
            'edit' => Pages\EditElemento::route('/{record}/edit'),
        ];
    }
}
