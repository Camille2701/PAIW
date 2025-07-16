<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SizeResource\Pages;
use App\Filament\Resources\SizeResource\RelationManagers;
use App\Models\Size;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SizeResource extends Resource
{
    protected static ?string $model = Size::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-pointing-out';

    protected static ?string $navigationGroup = 'Configuration';

    protected static ?string $navigationLabel = 'Tailles';

    protected static ?string $modelLabel = 'Taille';

    protected static ?string $pluralModelLabel = 'Tailles';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Information de la taille')
                    ->description('Définissez l\'étiquette de la taille')
                    ->schema([
                        Forms\Components\TextInput::make('label')
                            ->label('Étiquette de taille')
                            ->required()
                            ->maxLength(10)
                            ->placeholder('Ex: XS, S, M, L, XL, XXL...')
                            ->helperText('Utilisez les conventions standards (XS, S, M, L, XL) ou des tailles numériques'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('label')
                    ->label('Taille')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->badge()
                    ->color('info'),

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
            ->defaultSort('label');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Détails de la taille')
                    ->schema([
                        TextEntry::make('label')
                            ->label('Étiquette de taille')
                            ->size('lg')
                            ->weight('bold')
                            ->badge()
                            ->color('info'),
                    ]),

                Section::make('Informations système')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Créé le')
                            ->dateTime('d/m/Y à H:i')
                            ->placeholder('Non disponible'),

                        TextEntry::make('updated_at')
                            ->label('Dernière modification')
                            ->dateTime('d/m/Y à H:i')
                            ->placeholder('Jamais modifié')
                            ->formatStateUsing(function ($record) {
                                // Si pas de modification, afficher la date de création
                                if ($record->updated_at->eq($record->created_at)) {
                                    return $record->created_at->format('d/m/Y à H:i') . ' (création)';
                                }
                                return $record->updated_at->format('d/m/Y à H:i');
                            }),
                    ])
                    ->columns(2),
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
            'index' => Pages\ListSizes::route('/'),
            'create' => Pages\CreateSize::route('/create'),
            'view' => Pages\ViewSize::route('/{record}'),
            'edit' => Pages\EditSize::route('/{record}/edit'),
        ];
    }
}
