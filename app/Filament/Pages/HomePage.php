<?php

namespace App\Filament\Pages;

use App\Models\HomePageSettings;
use Filament\Actions\Action;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Enums\Alignment;

class HomePage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Page d\'accueil';
    protected static ?string $title = 'Gestion de la page d\'accueil';
    protected static string $view = 'filament.pages.home-page';
    protected static ?int $navigationSort = 2;

    public ?array $data = [];

    public function mount(): void
    {
        $instance = HomePageSettings::instance();

        $this->form->fill([
            'hero_image' => $instance->getMedia('homepage-hero'),
            'promotion_image' => $instance->getMedia('homepage-promotion'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('🎨 Gestion des images de la page d\'accueil')
                    ->description('Gérez les images principales de votre site web')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                // Upload Hero Image avec SpatieMediaLibraryFileUpload
                                Section::make('🎯 Image Hero')
                                    ->description('Image principale en bannière')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('hero_image')
                                            ->label('Image Hero')
                                            ->collection('homepage-hero')
                                            ->disk('public')
                                            ->visibility('public')
                                            ->image()
                                            ->imageEditor()
                                            ->imageEditorAspectRatios([
                                                '16:9',
                                                '21:9',
                                                '2:1',
                                            ])
                                            ->maxSize(10240) // 10MB
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                            ->preserveFilenames()
                                            ->multiple(false)
                                            ->reorderable(false)
                                            ->helperText('📐 Ratio recommandé: 16:9 ou 21:9 | 📁 Max: 10MB'),
                                    ])
                                    ->columnSpan(1),

                                // Upload Promotion Image avec SpatieMediaLibraryFileUpload
                                Section::make('🎨 Image Promotion')
                                    ->description('Image pour les sections promotionnelles')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('promotion_image')
                                            ->label('Image Promotion')
                                            ->collection('homepage-promotion')
                                            ->disk('public')
                                            ->visibility('public')
                                            ->image()
                                            ->imageEditor()
                                            ->imageEditorAspectRatios([
                                                '16:9',
                                                '4:3',
                                                '1:1',
                                                '3:2',
                                            ])
                                            ->maxSize(10240) // 10MB
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                            ->preserveFilenames()
                                            ->multiple(false)
                                            ->reorderable(false)
                                            ->helperText('📐 Formats flexibles | 📁 Max: 10MB'),
                                    ])
                                    ->columnSpan(1),
                            ]),
                    ]),
            ])
            ->model(HomePageSettings::instance())
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Enregistrer les modifications')
                ->submit('save')
                ->color('primary')
                ->size('lg')
                ->icon('heroicon-o-check-circle'),
        ];
    }

    protected function hasFullWidthFormActions(): bool
    {
        return false;
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // Sauvegarder les données du formulaire sur l'instance
        $this->form->model(HomePageSettings::instance())->saveRelationships();

        Notification::make()
            ->success()
            ->title('Images mises à jour !')
            ->body('Les images de la page d\'accueil ont été mises à jour avec succès.')
            ->duration(5000)
            ->send();

        // Actualiser les données
        $this->mount();
    }
}
