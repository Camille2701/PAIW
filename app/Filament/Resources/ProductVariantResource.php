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
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required(),
                Forms\Components\Select::make('size_id')
                    ->relationship('size', 'label')
                    ->required(),
                Forms\Components\Select::make('color_id')
                    ->relationship('color', 'name')
                    ->required(),
                Forms\Components\TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Produit')
                    ->sortable()
                    ->searchable(),
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
                    ->color(fn (string $state): string => match ($state) {
                        'men' => 'info',
                        'women' => 'pink',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('size.label')
                    ->label('Taille')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('gray'),
                Tables\Columns\ColorColumn::make('color.hex_code')
                    ->label('Couleur')
                    ->sortable()
                    ->alignCenter()
                    ->tooltip(fn ($record) => $record->color->name),
                Tables\Columns\TextColumn::make('color.name')
                    ->label('Nom Couleur')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('stock')
                    ->label('Stock')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        $state == 0 => 'danger',
                        $state < 5 => 'warning',
                        default => 'success',
                    }),
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
                Tables\Filters\SelectFilter::make('product_id')
                    ->label('Produit')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('gender')
                    ->label('Genre')
                    ->options([
                        'men' => '👨 Homme',
                        'women' => '👩 Femme',
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
                Tables\Filters\SelectFilter::make('color_id')
                    ->label('Couleur')
                    ->relationship('color', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('size_id')
                    ->label('Taille')
                    ->relationship('size', 'label')
                    ->searchable()
                    ->preload(),
                Tables\Filters\Filter::make('out_of_stock')
                    ->label('Rupture de stock')
                    ->query(fn (Builder $query): Builder => $query->where('stock', '=', 0)),
                Tables\Filters\Filter::make('low_stock')
                    ->label('Stock faible (< 5)')
                    ->query(fn (Builder $query): Builder => $query->where('stock', '<', 5)->where('stock', '>', 0)),
            ])
            ->defaultSort('product_id')
            ->groups([
                'product.name',
                'color.name',
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListProductVariants::route('/'),
            'create' => Pages\CreateProductVariant::route('/create'),
            'view' => Pages\ViewProductVariant::route('/{record}'),
            'edit' => Pages\EditProductVariant::route('/{record}/edit'),
        ];
    }
}
