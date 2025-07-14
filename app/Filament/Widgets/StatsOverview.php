<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Produits', Product::count())
                ->description('Nombre total de produits')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Variantes en Stock', ProductVariant::where('stock', '>', 0)->count())
                ->description('Variantes disponibles')
                ->descriptionIcon('heroicon-m-cube')
                ->color('primary'),

            Stat::make('Stock Total', ProductVariant::sum('stock'))
                ->description('Unités en stock')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('info'),

            Stat::make('Utilisateurs', User::count())
                ->description('Clients inscrits')
                ->descriptionIcon('heroicon-m-users')
                ->color('warning'),
        ];
    }
}
