<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Traits\HasSoftDeleteToggle;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\RepeatableEntry;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    use HasSoftDeleteToggle;
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Commandes';

    protected static ?string $modelLabel = 'Commande';

    protected static ?string $pluralModelLabel = 'Commandes';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['orderItems.productVariant.product', 'orderItems.productVariant.color', 'orderItems.productVariant.size'])
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations de la commande')
                    ->description('Détails de base de la commande')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Statut')
                            ->options([
                                'pending' => 'En attente',
                                'processing' => 'En cours',
                                'shipped' => 'Expédiée',
                                'delivered' => 'Livrée',
                                'cancelled' => 'Annulée',
                                'paid' => 'Payé',
                            ])
                            ->default('pending')
                            ->required(),

                        Forms\Components\Select::make('user_id')
                            ->label('Client')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload(),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Montants')
                    ->description('Détails financiers de la commande')
                    ->schema([
                        Forms\Components\TextInput::make('subtotal')
                            ->label('Sous-total')
                            ->numeric()
                            ->prefix('€')
                            ->disabled(),

                        Forms\Components\TextInput::make('shipping_price')
                            ->label('Frais de livraison')
                            ->numeric()
                            ->prefix('€')
                            ->disabled(),

                        Forms\Components\TextInput::make('discount_amount')
                            ->label('Montant de réduction')
                            ->numeric()
                            ->prefix('€')
                            ->disabled(),

                        Forms\Components\TextInput::make('total_price')
                            ->label('Total')
                            ->numeric()
                            ->prefix('€')
                            ->disabled(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Informations de livraison')
                    ->description('Adresse et méthode de livraison')
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->label('Prénom')
                            ->required(),

                        Forms\Components\TextInput::make('last_name')
                            ->label('Nom')
                            ->required(),

                        Forms\Components\TextInput::make('street')
                            ->label('Adresse')
                            ->required(),

                        Forms\Components\TextInput::make('apartment')
                            ->label('Appartement'),

                        Forms\Components\TextInput::make('city')
                            ->label('Ville')
                            ->required(),

                        Forms\Components\TextInput::make('postal_code')
                            ->label('Code postal')
                            ->required(),

                        Forms\Components\TextInput::make('country')
                            ->label('Pays')
                            ->required(),

                        Forms\Components\TextInput::make('shipping_method')
                            ->label('Méthode de livraison')
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Informations supplémentaires')
                    ->schema([
                        Forms\Components\TextInput::make('coupon_code')
                            ->label('Code de coupon'),

                        Forms\Components\TextInput::make('coupon_discount')
                            ->label('Pourcentage de réduction')
                            ->numeric()
                            ->suffix('%'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('N°')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Client')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Invité'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'processing' => 'primary',
                        'shipped' => 'info',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        'paid' => 'success',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'pending' => 'heroicon-o-clock',
                        'processing' => 'heroicon-o-cog-6-tooth',
                        'shipped' => 'heroicon-o-truck',
                        'delivered' => 'heroicon-o-check-circle',
                        'cancelled' => 'heroicon-o-x-circle',
                        'paid' => 'heroicon-o-check-badge',
                        default => 'heroicon-o-question-mark-circle',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'En attente',
                        'processing' => 'En cours',
                        'shipped' => 'Expédiée',
                        'delivered' => 'Livrée',
                        'cancelled' => 'Annulée',
                        'paid' => 'Payé',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total')
                    ->money('EUR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_quantity')
                    ->label('Articles')
                    ->state(function ($record) {
                        $totalQty = $record->orderItems->sum('quantity');
                        $uniqueProducts = $record->orderItems->count();
                        return $totalQty . ' pcs (' . $uniqueProducts . ' produit' . ($uniqueProducts > 1 ? 's' : '') . ')';
                    })
                    ->tooltip(function ($record) {
                        return $record->orderItems->map(function ($item) {
                            $product = $item->productVariant->product->name ?? 'Produit supprimé';
                            $color = $item->productVariant->color->name ?? 'N/A';
                            $size = $item->productVariant->size->name ?? 'N/A';
                            return "• {$product} ({$color}, {$size}) x{$item->quantity}";
                        })->implode("\n");
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('shipping_method')
                    ->label('Livraison')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'ups_standard' => 'UPS Standard',
                        'ups_premium' => 'UPS Premium',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date de commande')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Statut')
                    ->options([
                        'pending' => 'En attente',
                        'processing' => 'En cours',
                        'shipped' => 'Expédiée',
                        'delivered' => 'Livrée',
                        'cancelled' => 'Annulée',
                        'paid' => 'Payé',
                    ]),

                Tables\Filters\Filter::make('created_at')
                    ->label('Date de commande')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Du'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Au'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
                static::getTrashedToggleFilter(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('📋 Informations de la commande')
                    ->description('Détails principaux de la commande')
                    ->schema([
                        TextEntry::make('id')
                            ->label('Numéro de commande')
                            ->badge()
                            ->color('primary')
                            ->prefix('#'),

                        TextEntry::make('status')
                            ->label('Statut')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'processing' => 'primary',
                                'shipped' => 'info',
                                'delivered' => 'success',
                                'cancelled' => 'danger',
                                'paid' => 'success',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'pending' => '🕐 En attente',
                                'processing' => '⚙️ En cours',
                                'shipped' => '🚚 Expédiée',
                                'delivered' => '✅ Livrée',
                                'cancelled' => '❌ Annulée',
                                'paid' => '💰 Payé',
                                default => $state,
                            }),

                        TextEntry::make('user.name')
                            ->label('Client')
                            ->placeholder('👤 Client invité')
                            ->icon('heroicon-o-user'),

                        TextEntry::make('email')
                            ->label('Email')
                            ->icon('heroicon-o-envelope')
                            ->copyable(),

                        TextEntry::make('created_at')
                            ->label('Date de commande')
                            ->dateTime('d/m/Y à H:i')
                            ->icon('heroicon-o-calendar'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('📍 Informations de livraison')
                    ->description('Adresse et méthode de livraison')
                    ->schema([
                        TextEntry::make('shipping_address')
                            ->label('Adresse complète')
                            ->state(function ($record) {
                                return collect([
                                    $record->first_name . ' ' . $record->last_name,
                                    $record->street . ($record->apartment ? ', ' . $record->apartment : ''),
                                    $record->postal_code . ' ' . $record->city,
                                    $record->country,
                                ])->filter()->implode("\n");
                            })
                            ->html()
                            ->icon('heroicon-o-map-pin'),

                        TextEntry::make('shipping_method')
                            ->label('Méthode de livraison')
                            ->badge()
                            ->color('info')
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'ups_standard' => '📦 UPS Standard (Gratuit)',
                                'ups_premium' => '🚀 UPS Premium (4,99€)',
                                default => $state,
                            }),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('🛍️ Articles commandés')
                    ->description('Détail de tous les articles de cette commande')
                    ->schema([
                        RepeatableEntry::make('orderItems')
                            ->label('')
                            ->schema([
                                TextEntry::make('productVariant.product.name')
                                    ->label('Produit')
                                    ->weight('bold')
                                    ->color('primary'),

                                TextEntry::make('productVariant.color.name')
                                    ->label('Couleur')
                                    ->badge()
                                    ->color('info'),

                                TextEntry::make('productVariant.size.name')
                                    ->label('Taille')
                                    ->badge()
                                    ->color('warning'),

                                TextEntry::make('quantity')
                                    ->label('Quantité')
                                    ->badge()
                                    ->color('success')
                                    ->suffix(' pcs'),

                                TextEntry::make('unit_price')
                                    ->label('Prix unitaire')
                                    ->money('EUR'),

                                TextEntry::make('total_price')
                                    ->label('Total')
                                    ->money('EUR')
                                    ->weight('bold')
                                    ->color('primary'),
                            ])
                            ->columns(6)
                            ->contained(false)
                    ])
                    ->collapsible(),

                Section::make('�💰 Résumé financier')
                    ->description('Détails des montants')
                    ->schema([
                        TextEntry::make('subtotal')
                            ->label('Sous-total')
                            ->money('EUR')
                            ->color('gray'),

                        TextEntry::make('shipping_price')
                            ->label('Frais de livraison')
                            ->money('EUR')
                            ->color('info'),

                        TextEntry::make('discount_amount')
                            ->label('Réduction')
                            ->money('EUR')
                            ->color('success')
                            ->visible(fn ($record) => $record->discount_amount > 0),

                        TextEntry::make('coupon_code')
                            ->label('Code promo utilisé')
                            ->badge()
                            ->color('success')
                            ->visible(fn ($record) => $record->coupon_code),

                        TextEntry::make('total_price')
                            ->label('Total final')
                            ->money('EUR')
                            ->size('lg')
                            ->weight('bold')
                            ->color('primary'),

                        TextEntry::make('articles_count')
                            ->label('Nombre d\'articles')
                            ->state(function ($record) {
                                return $record->orderItems->sum('quantity');
                            })
                            ->badge()
                            ->color('warning')
                            ->suffix(' article(s)'),
                    ])
                    ->columns(3)
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
