<?php

namespace App\Filament\Widgets;

use App\Models\ProductVariant;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class QuickActions extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $lowStockVariants = ProductVariant::where('stock', '<', 5)->where('stock', '>', 0)->count();
        $outOfStockVariants = ProductVariant::where('stock', '=', 0)->count();
        $totalProducts = Product::count();
        $averageStock = ProductVariant::avg('stock');

        return [
            Stat::make('Stock Faible', $lowStockVariants)
                ->description('Variantes < 5 unités')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('warning')
                ->url('/admin/product-variants?tableFilters[low_stock][isActive]=true'),

            Stat::make('Ruptures', $outOfStockVariants)
                ->description('Variantes épuisées')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger')
                ->url('/admin/product-variants?tableFilters[out_of_stock][isActive]=true'),

            Stat::make('Stock Moyen', number_format($averageStock, 1))
                ->description('Par variante')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('info'),
        ];
    }
}
