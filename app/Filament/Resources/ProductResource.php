<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\ImageEntry;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Actions;
use Illuminate\Support\Facades\Log;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Catalogue';

    protected static ?string $modelLabel = 'Produit';

    protected static ?string $pluralModelLabel = 'Produits';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations générales')
                    ->description('Détails de base du produit')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nom')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $context, $state, callable $set) =>
                                $context === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null
                            ),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('URL conviviale du produit'),

                        Forms\Components\Select::make('product_type_id')
                            ->label('Type de produit')
                            ->relationship('productType', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Contenu')
                    ->description('Description et détails du produit')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Prix')
                    ->description('Information de tarification')
                    ->schema([
                        Forms\Components\TextInput::make('price')
                            ->label('Prix')
                            ->required()
                            ->numeric()
                            ->prefix('€')
                            ->step(0.01)
                            ->minValue(0),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Images par couleur')
                    ->description('Gérez les images pour chaque couleur existante de ce produit. Les couleurs sont chargées automatiquement selon les variantes disponibles.')
                    ->hidden(fn ($operation) => $operation === 'create')
                    ->schema([
                        Forms\Components\Placeholder::make('color_instructions')
                            ->label('Instructions')
                            ->content('Vous pouvez ajouter une image pour chaque couleur de variante ci-dessous.')
                            ->columnSpanFull(),

                        Forms\Components\Group::make()
                            ->schema(function ($record) {
                                if (!$record) {
                                    return [];
                                }

                                $variants = $record->variants()->with('color')->get();
                                $colors = $variants->pluck('color')->filter()->unique('id');

                                $fields = [];
                                foreach ($colors as $color) {
                                    $fields[] = SpatieMediaLibraryFileUpload::make("color_image_{$color->id}")
                                        ->label("Image pour {$color->name}")
                                        ->collection("color_{$color->id}") // Collection unique par couleur
                                        ->directory("products/color_{$color->id}") // Dossier organisé par couleur
                                        ->disk('public') // Forcer l'utilisation du disque public
                                        ->visibility('public') // Rendre les fichiers publics
                                        ->image()
                                        ->imageEditor()
                                        ->helperText("Ajoutez une image pour la couleur {$color->name}")
                                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'])
                                        ->maxSize(2048)
                                        ->preserveFilenames()
                                        ->multiple(false)
                                        ->reorderable(false);
                                }

                                return $fields;
                            })
                            ->columnSpanFull(),
                    ]),
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

                Tables\Columns\TextColumn::make('productType.name')
                    ->label('Type')
                    ->sortable()
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('price')
                    ->label('Prix')
                    ->money('EUR')
                    ->sortable()
                    ->color('success'),

                Tables\Columns\TextColumn::make('variants_count')
                    ->label('Variantes')
                    ->counts('variants')
                    ->badge()
                    ->color('warning'),

                Tables\Columns\TextColumn::make('colors_count')
                    ->label('Couleurs')
                    ->getStateUsing(function ($record) {
                        return $record->variants()->distinct('color_id')->count('color_id');
                    })
                    ->badge()
                    ->color('info')
                    ->alignment('center'),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Slug copié!')
                    ->copyMessageDuration(1500)
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
                Tables\Filters\SelectFilter::make('product_type_id')
                    ->label('Type de produit')
                    ->relationship('productType', 'name'),

                Tables\Filters\Filter::make('has_variants')
                    ->label('Avec variantes')
                    ->query(fn (Builder $query): Builder => $query->has('variants')),
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
            ->defaultSort('created_at', 'desc');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('🛍️ Informations du produit')
                    ->description('Détails principaux du produit')
                    ->schema([
                        TextEntry::make('name')
                            ->label('👕 Nom')
                            ->size('lg')
                            ->weight('bold')
                            ->icon('heroicon-o-tag'),

                        TextEntry::make('slug')
                            ->label('🔗 Slug')
                            ->copyable()
                            ->copyMessage('Slug copié!')
                            ->badge()
                            ->color('info'),

                        TextEntry::make('productType.name')
                            ->label('🗂️ Type de produit')
                            ->badge()
                            ->color('info'),

                        TextEntry::make('price')
                            ->label('💰 Prix')
                            ->money('EUR')
                            ->color('success')
                            ->weight('bold'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('📝 Description')
                    ->description('Contenu descriptif du produit')
                    ->schema([
                        TextEntry::make('description')
                            ->label('Description')
                            ->markdown()
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Section::make('📊 Statistiques')
                    ->description('Données sur les variantes disponibles')
                    ->schema([
                        TextEntry::make('variants_count')
                            ->label('🎯 Nombre de variantes')
                            ->badge()
                            ->color('warning')
                            ->getStateUsing(function ($record) {
                                return $record->variants()->count();
                            }),

                        TextEntry::make('colors_count')
                            ->label('🎨 Couleurs disponibles')
                            ->badge()
                            ->color('info')
                            ->getStateUsing(function ($record) {
                                return $record->variants()->distinct('color_id')->count('color_id');
                            }),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('🎨 Couleurs avec images')
                    ->description('État des images par couleur')
                    ->schema([
                        TextEntry::make('product_colors_with_images')
                            ->label('')
                            ->getStateUsing(function ($record) {
                                $variants = $record->variants()->with('color')->get();
                                $colors = $variants->pluck('color')->filter()->unique('id');

                                if ($colors->isEmpty()) {
                                    return '❌ Aucune couleur disponible';
                                }

                                $colorList = [];
                                foreach ($colors as $color) {
                                    // Chercher l'image dans la collection spécifique à la couleur
                                    $colorImage = $record->getMedia("color_{$color->id}")->first();

                                    if ($colorImage) {
                                        $colorList[] = "✅ {$color->name} - Image disponible";
                                    } else {
                                        $colorList[] = "❌ {$color->name} - Pas d'image";
                                    }
                                }

                                return implode("\n", $colorList);
                            })
                            ->columnSpanFull(),
                    ])
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
