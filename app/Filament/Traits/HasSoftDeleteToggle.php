<?php

namespace App\Filament\Traits;

use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Toggle;

trait HasSoftDeleteToggle
{
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getTrashedToggleFilter(): Filter
    {
        return Filter::make('trashed_toggle')
            ->label('🗑️ Afficher la corbeille')
            ->form([
                Toggle::make('show_trashed')
                    ->label('Voir uniquement les éléments supprimés')
                    ->default(false)
                    ->helperText('Activez pour voir uniquement les éléments dans la corbeille'),
            ])
            ->query(function (Builder $query, array $data): Builder {
                if ($data['show_trashed'] ?? false) {
                    return $query->onlyTrashed();
                }
                return $query->withoutTrashed();
            })
            ->indicateUsing(function (array $data): ?string {
                if ($data['show_trashed'] ?? false) {
                    return '🗑️ Mode corbeille actif';
                }
                return null;
            });
    }
}
