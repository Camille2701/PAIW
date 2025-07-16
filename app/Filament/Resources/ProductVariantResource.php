<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductVariantResource\Pages;
use App\Filament\Resources\ProductVariantResource\RelationManagers;
use App\Models\ProductVariant;
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

class ProductVariantResource extends Resource
{
    protected static ?string $model = ProductVariant::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationGroup = 'Catalogue';

    protected static ?string $modelLabel = 'Variante de Produit';

    protected static ?string $pluralModelLabel = 'Variantes de Produits';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations de la variante')
                    ->description('Sélectionnez le produit et ses caractéristiques')
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->label('Produit')
                            ->relationship('product', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\Select::make('size_id')
                            ->label('Taille')
                            ->relationship('size', 'label')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\Select::make('color_id')
                            ->label('Couleur')
                            ->relationship('color', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Stock et identification')
                    ->description('Gestion des stocks et référence produit')
                    ->schema([
                        Forms\Components\TextInput::make('sku')
                            ->label('SKU (Référence)')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->placeholder('Ex: TSH-BLU-M-001'),

                        Forms\Components\TextInput::make('stock')
                            ->label('Quantité en stock')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->step(1),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Produit')
                    ->sortable()
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->copyable()
                    ->badge()
                    ->color('gray')
                    ->placeholder('Non disponible')
                    ->formatStateUsing(fn ($state) => $state ?: 'Non disponible'),

                Tables\Columns\TextColumn::make('size.label')
                    ->label('Taille')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('info'),

                Tables\Columns\ColorColumn::make('color.hex_code')
                    ->label('Couleur')
                    ->sortable()
                    ->tooltip(fn ($record) => $record->color->name)
                    ->alignment('center'),

                Tables\Columns\TextColumn::make('stock')
                    ->label('Stock')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(fn ($state): string => match (true) {
                        $state == 0 => 'danger',
                        $state < 5 => 'warning',
                        default => 'success',
                    })
                    ->alignment('center'),

                Tables\Columns\TextColumn::make('product.productType.gender')
                    ->label('Genre')
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        return match($state) {
                            'men' => 'Homme',
                            'women' => 'Femme',
                            default => 'Non défini'
                        };
                    })
                    ->badge()
                    ->color(fn ($state): string => match ($state) {
                        'men' => 'info',
                        'women' => 'success',
                        default => 'gray',
                    })
                    ->toggleable(),

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
                Tables\Filters\SelectFilter::make('product_id')
                    ->label('Produit')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('size_id')
                    ->label('Taille')
                    ->relationship('size', 'label')
                    ->multiple(),

                Tables\Filters\SelectFilter::make('color_id')
                    ->label('Couleur')
                    ->relationship('color', 'name')
                    ->multiple(),

                Tables\Filters\SelectFilter::make('gender')
                    ->label('Genre')
                    ->options([
                        'men' => 'Homme',
                        'women' => 'Femme',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'],
                            fn (Builder $query, $gender): Builder => $query->whereHas(
                                'product.productType',
                                fn (Builder $query): Builder => $query->where('gender', $gender)
                            )
                        );
                    }),

                Tables\Filters\Filter::make('out_of_stock')
                    ->label('Rupture de stock')
                    ->query(fn (Builder $query): Builder => $query->where('stock', '=', 0)),

                Tables\Filters\Filter::make('low_stock')
                    ->label('Stock faible (< 5)')
                    ->query(fn (Builder $query): Builder => $query->where('stock', '<', 5)->where('stock', '>', 0)),
            ])
            ->defaultSort('created_at', 'desc')
            ->groups([
                'product.name',
                'color.name',
                'size.label',
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
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informations de la variante')
                    ->schema([
                        TextEntry::make('sku')
                            ->label('SKU')
                            ->copyable()
                            ->badge()
                            ->color('gray')
                            ->placeholder('Aucun SKU défini')
                            ->formatStateUsing(fn ($state) => $state ?: 'Non défini'),

                        TextEntry::make('product.name')
                            ->label('Produit')
                            ->size('lg')
                            ->weight('bold'),

                        TextEntry::make('size.label')
                            ->label('Taille')
                            ->badge()
                            ->color('info'),

                        TextEntry::make('color.name')
                            ->label('Couleur')
                            ->badge()
                            ->color('success'),

                        TextEntry::make('stock')
                            ->label('Stock disponible')
                            ->badge()
                            ->color(fn ($state): string => match (true) {
                                $state == 0 => 'danger',
                                $state < 5 => 'warning',
                                default => 'success',
                            })
                            ->formatStateUsing(fn ($state) => $state . ' unité' . ($state > 1 ? 's' : '')),
                    ])
                    ->columns(3),

                Section::make('Détails du produit')
                    ->schema([
                        TextEntry::make('product.productType.name')
                            ->label('Type de produit')
                            ->badge(),

                        TextEntry::make('product.productType.gender')
                            ->label('Genre')
                            ->formatStateUsing(fn ($state) => match($state) {
                                'men' => 'Homme',
                                'women' => 'Femme',
                                default => 'Non défini'
                            })
                            ->badge()
                            ->color(fn ($state): string => match ($state) {
                                'men' => 'info',
                                'women' => 'success',
                                default => 'gray',
                            }),

                        TextEntry::make('product.price')
                            ->label('Prix du produit')
                            ->money('EUR')
                            ->color('success'),
                    ])
                    ->columns(3),

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
            'index' => Pages\ListProductVariants::route('/'),
            'create' => Pages\CreateProductVariant::route('/create'),
            'view' => Pages\ViewProductVariant::route('/{record}'),
            'edit' => Pages\EditProductVariant::route('/{record}/edit'),
        ];
    }
}
