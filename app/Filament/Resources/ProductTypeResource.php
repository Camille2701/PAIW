<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductTypeResource\Pages;
use App\Filament\Resources\ProductTypeResource\RelationManagers;
use App\Models\ProductType;
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

class ProductTypeResource extends Resource
{
    protected static ?string $model = ProductType::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Configuration';

    protected static ?string $navigationLabel = 'Types de Produits';

    protected static ?string $modelLabel = 'Type de Produit';

    protected static ?string $pluralModelLabel = 'Types de Produits';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations du type de produit')
                    ->description('Définissez les caractéristiques du type de produit')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nom du type')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Ex: T-shirt, Pantalon, Robe...'),

                        Forms\Components\Select::make('gender')
                            ->label('Genre cible')
                            ->options([
                                'men' => 'Hommes',
                                'women' => 'Femmes',
                            ])
                            ->required()
                            ->native(false),
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

                Tables\Columns\TextColumn::make('gender')
                    ->label('Genre')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'men' => 'Hommes',
                        'women' => 'Femmes',
                        default => $state,
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'men' => 'info',
                        'women' => 'success',
                        default => 'gray',
                    })
                    ->searchable(),

                Tables\Columns\TextColumn::make('products_count')
                    ->label('Produits')
                    ->counts('products')
                    ->badge()
                    ->color('warning'),

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
                Tables\Filters\SelectFilter::make('gender')
                    ->label('Genre')
                    ->options([
                        'men' => 'Hommes',
                        'women' => 'Femmes',
                    ]),
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
                Section::make('Détails du type de produit')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nom')
                            ->size('lg')
                            ->weight('bold'),

                        TextEntry::make('gender')
                            ->label('Genre cible')
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'men' => 'Hommes',
                                'women' => 'Femmes',
                                default => $state,
                            })
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'men' => 'info',
                                'women' => 'success',
                                default => 'gray',
                            }),
                    ])
                    ->columns(2),

                Section::make('Statistiques')
                    ->schema([
                        TextEntry::make('products_count')
                            ->label('Nombre de produits')
                            ->getStateUsing(fn ($record) => $record->products()->count())
                            ->badge()
                            ->color('warning'),

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
                    ->columns(3),
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
            'index' => Pages\ListProductTypes::route('/'),
            'create' => Pages\CreateProductType::route('/create'),
            'view' => Pages\ViewProductType::route('/{record}'),
            'edit' => Pages\EditProductType::route('/{record}/edit'),
        ];
    }
}
