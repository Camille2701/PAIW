<?php

namespace App\Filament\Components;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\Concerns\HasPlaceholder;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Group;
use App\Models\Color;

class ProductColorImages extends Field
{
    use HasPlaceholder;

    protected string $view = 'filament.forms.components.product-color-images';

    public static function make(string $name = 'color_images'): static
    {
        return parent::make($name);
    }

    public function getChildComponents(): array
    {
        return [
            Repeater::make('color_images')
                ->label('Images par couleur')
                ->schema([
                    Group::make([
                        Select::make('color_id')
                            ->label('Couleur')
                            ->options(Color::all()->pluck('name', 'id'))
                            ->required()
                            ->searchable(),

                        FileUpload::make('image')
                            ->label('Image')
                            ->image()
                            ->imageEditor()
                            ->required()
                            ->directory('product-colors')
                            ->visibility('public'),
                    ])->columns(2)
                ])
                ->addActionLabel('Ajouter une image de couleur')
                ->reorderable(false)
                ->collapsible()
                ->itemLabel(fn (array $state): ?string =>
                    $state['color_id'] ? Color::find($state['color_id'])?->name : null
                ),
        ];
    }
}
