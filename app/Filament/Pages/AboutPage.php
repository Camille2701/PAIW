<?php

namespace App\Filament\Pages;

use App\Models\AboutPage as AboutPageModel;
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

class AboutPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Page À propos';
    protected static ?string $title = 'Gestion de la page À propos';
    protected static string $view = 'filament.pages.about-page';
    protected static ?int $navigationSort = 3;

    public ?array $data = [];

    public function mount(): void
    {
        $instance = AboutPageModel::instance();

        $this->form->fill([
            'alexis_image' => $instance->getMedia('about-alexis'),
            'camille_image' => $instance->getMedia('about-camille'),
            'clement_image' => $instance->getMedia('about-clement'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('👥 Gestion des images de l\'équipe')
                    ->description('Gérez les photos des membres de l\'équipe')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                // Upload Alexis Image
                                Section::make('👨‍💼 Alexis')
                                    ->description('Photo d\'Alexis')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('alexis_image')
                                            ->label('Photo d\'Alexis')
                                            ->collection('about-alexis')
                                            ->disk('public')
                                            ->visibility('public')
                                            ->image()
                                            ->imageEditor()
                                            ->imageEditorAspectRatios([
                                                '1:1',
                                                '4:3',
                                                '3:2',
                                            ])
                                            ->maxSize(10240) // 10MB
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                            ->preserveFilenames()
                                            ->multiple(false)
                                            ->reorderable(false)
                                            ->helperText('📐 Ratio recommandé: 1:1 | 📁 Max: 10MB'),
                                    ])
                                    ->columnSpan(1),

                                // Upload Camille Image
                                Section::make('👩‍💼 Camille')
                                    ->description('Photo de Camille')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('camille_image')
                                            ->label('Photo de Camille')
                                            ->collection('about-camille')
                                            ->disk('public')
                                            ->visibility('public')
                                            ->image()
                                            ->imageEditor()
                                            ->imageEditorAspectRatios([
                                                '1:1',
                                                '4:3',
                                                '3:2',
                                            ])
                                            ->maxSize(10240) // 10MB
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                            ->preserveFilenames()
                                            ->multiple(false)
                                            ->reorderable(false)
                                            ->helperText('📐 Ratio recommandé: 1:1 | 📁 Max: 10MB'),
                                    ])
                                    ->columnSpan(1),

                                // Upload Clément Image
                                Section::make('👨‍💼 Clément')
                                    ->description('Photo de Clément')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('clement_image')
                                            ->label('Photo de Clément')
                                            ->collection('about-clement')
                                            ->disk('public')
                                            ->visibility('public')
                                            ->image()
                                            ->imageEditor()
                                            ->imageEditorAspectRatios([
                                                '1:1',
                                                '4:3',
                                                '3:2',
                                            ])
                                            ->maxSize(10240) // 10MB
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                            ->preserveFilenames()
                                            ->multiple(false)
                                            ->reorderable(false)
                                            ->helperText('📐 Ratio recommandé: 1:1 | 📁 Max: 10MB'),
                                    ])
                                    ->columnSpan(1),
                            ]),
                    ]),
            ])
            ->model(AboutPageModel::instance())
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
        $this->form->model(AboutPageModel::instance())->saveRelationships();

        Notification::make()
            ->success()
            ->title('Images mises à jour !')
            ->body('Les photos de l\'équipe ont été mises à jour avec succès.')
            ->duration(5000)
            ->send();

        // Actualiser les données
        $this->mount();
    }
}
