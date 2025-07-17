<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Calculer les statistiques des commandes
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_price');
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Comparer avec le mois précédent pour les commandes
        $currentMonth = now()->startOfMonth();
        $previousMonth = now()->subMonth()->startOfMonth();

        $currentMonthOrders = Order::where('created_at', '>=', $currentMonth)->count();
        $previousMonthOrders = Order::where('created_at', '>=', $previousMonth)
            ->where('created_at', '<', $currentMonth)->count();

        $ordersGrowth = $previousMonthOrders > 0
            ? (($currentMonthOrders - $previousMonthOrders) / $previousMonthOrders) * 100
            : 0;

        // Comparer le chiffre d'affaires
        $currentMonthRevenue = Order::where('created_at', '>=', $currentMonth)
            ->where('status', '!=', 'cancelled')
            ->sum('total_price');
        $previousMonthRevenue = Order::where('created_at', '>=', $previousMonth)
            ->where('created_at', '<', $currentMonth)
            ->where('status', '!=', 'cancelled')
            ->sum('total_price');

        $revenueGrowth = $previousMonthRevenue > 0
            ? (($currentMonthRevenue - $previousMonthRevenue) / $previousMonthRevenue) * 100
            : 0;

        return [
            Stat::make('Total Commandes', $totalOrders)
                ->description($ordersGrowth >= 0 ?
                    '+' . number_format($ordersGrowth, 1) . '% ce mois' :
                    number_format($ordersGrowth, 1) . '% ce mois')
                ->descriptionIcon($ordersGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($ordersGrowth >= 0 ? 'success' : 'danger'),

            Stat::make('Commandes en attente', $pendingOrders)
                ->description('À traiter')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Chiffre d\'affaires', '€' . number_format($totalRevenue, 2))
                ->description($revenueGrowth >= 0 ?
                    '+' . number_format($revenueGrowth, 1) . '% ce mois' :
                    number_format($revenueGrowth, 1) . '% ce mois')
                ->descriptionIcon($revenueGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($revenueGrowth >= 0 ? 'success' : 'danger'),

            Stat::make('Panier moyen', '€' . number_format($avgOrderValue, 2))
                ->description('Valeur moyenne des commandes')
                ->descriptionIcon('heroicon-m-calculator')
                ->color('info'),
        ];
    }
}
