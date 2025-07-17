<?php

namespace App\Filament\Widgets;

use App\Models\ProductVariant;
use Filament\Widgets\ChartWidget;

class ProductStockChart extends ChartWidget
{
    protected static ?string $heading = 'Stock par Produit';

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $variants = ProductVariant::with(['product', 'color', 'size'])
            ->selectRaw('product_id, SUM(stock) as total_stock')
            ->groupBy('product_id')
            ->orderBy('total_stock', 'desc')
            ->limit(8)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Stock Total',
                    'data' => $variants->pluck('total_stock')->toArray(),
                    'backgroundColor' => [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(139, 92, 246, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(6, 182, 212, 0.8)',
                        'rgba(132, 204, 22, 0.8)',
                        'rgba(249, 115, 22, 0.8)',
                    ],
                    'borderColor' => [
                        'rgba(59, 130, 246, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(139, 92, 246, 1)',
                        'rgba(245, 158, 11, 1)',
                        'rgba(239, 68, 68, 1)',
                        'rgba(6, 182, 212, 1)',
                        'rgba(132, 204, 22, 1)',
                        'rgba(249, 115, 22, 1)',
                    ],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $variants->map(function ($variant) {
                $name = $variant->product->name ?? 'Produit #' . $variant->product_id;
                return strlen($name) > 15 ? substr($name, 0, 15) . '...' : $name;
            })->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'grid' => [
                        'color' => 'rgba(156, 163, 175, 0.3)',
                    ],
                ],
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                ],
            ],
        ];
    }
}
