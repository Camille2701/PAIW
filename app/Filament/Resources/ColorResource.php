<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ColorResource\Pages;
use App\Filament\Resources\ColorResource\RelationManagers;
use App\Models\Color;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\ColorEntry;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ColorResource extends Resource
{
    protected static ?string $model = Color::class;

    protected static ?string $navigationIcon = 'heroicon-o-swatch';

    protected static ?string $navigationGroup = 'Configuration';

    protected static ?string $navigationLabel = 'Couleurs';

    protected static ?string $modelLabel = 'Couleur';

    protected static ?string $pluralModelLabel = 'Couleurs';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations de la couleur')
                    ->description('Définissez le nom et la teinte de la couleur')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nom de la couleur')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Ex: Rouge foncé, Bleu marine...'),

                        Forms\Components\ColorPicker::make('hex_code')
                            ->label('Code couleur')
                            ->required()
                            ->helperText('Sélectionnez la teinte exacte'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('hex_code')
                    ->label('Code couleur')
                    ->formatStateUsing(fn ($state) => $state)
                    ->copyable()
                    ->copyMessage('Code couleur copié!')
                    ->copyMessageDuration(1500)
                    ->badge()
                    ->color('gray')
                    ->fontFamily('mono'),

                Tables\Columns\ColorColumn::make('hex_code')
                    ->label('Couleur'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Modifié le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('🎨 Détails de la couleur')
                    ->description('Informations sur cette couleur')
                    ->schema([
                        TextEntry::make('name')
                            ->label('🏷️ Nom')
                            ->size('lg')
                            ->weight('bold')
                            ->icon('heroicon-o-tag'),

                        ColorEntry::make('hex_code')
                            ->label('🌈 Aperçu couleur'),

                        TextEntry::make('hex_code')
                            ->label('🔢 Code hexadécimal')
                            ->copyable()
                            ->copyMessage('Code couleur copié!')
                            ->badge()
                            ->color('gray')
                            ->prefix('#'),
                    ])
                    ->columns(3)
                    ->collapsible(),

                Section::make('⚙️ Informations système')
                    ->description('Données techniques et historique')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('📅 Créé le')
                            ->dateTime('d/m/Y à H:i')
                            ->placeholder('Non disponible')
                            ->icon('heroicon-o-calendar'),

                        TextEntry::make('updated_at')
                            ->label('🔄 Dernière modification')
                            ->dateTime('d/m/Y à H:i')
                            ->placeholder('Jamais modifié')
                            ->icon('heroicon-o-clock')
                            ->formatStateUsing(function ($record) {
                                // Si pas de modification, afficher la date de création
                                if ($record->updated_at->eq($record->created_at)) {
                                    return $record->created_at->format('d/m/Y à H:i') . ' (création)';
                                }
                                return $record->updated_at->format('d/m/Y à H:i');
                            }),
                    ])
                    ->columns(2)
                    ->collapsible(),
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
            'index' => Pages\ListColors::route('/'),
            'create' => Pages\CreateColor::route('/create'),
            'view' => Pages\ViewColor::route('/{record}'),
            'edit' => Pages\EditColor::route('/{record}/edit'),
        ];
    }
}
