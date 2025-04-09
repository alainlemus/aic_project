<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TipoOrdenResource\Pages;
use App\Models\TipoOrden;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;

class TipoOrdenResource extends Resource
{
    protected static ?string $model = TipoOrden::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    protected static ?string $label = "Tipos";

    protected static ?string $navigationGroup = 'Ordenes';

    protected static ?string $navigationBadgeTooltip = 'Número de tipos de orden';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Datos del tipo de orden')
                ->description('Registra los datos del tipo de orden')
                    ->schema([
                        Forms\Components\TextInput::make('nombre')
                            ->required()
                            ->maxLength(255),
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
            ->emptyStateHeading('Ningun tipo de orden registrado')
            ->emptyStateDescription('Cuando registres tipos de orden, apareceran aqui.')
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
            'index' => Pages\ListTipoOrdens::route('/'),
            'create' => Pages\CreateTipoOrden::route('/create'),
            'edit' => Pages\EditTipoOrden::route('/{record}/edit'),
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
