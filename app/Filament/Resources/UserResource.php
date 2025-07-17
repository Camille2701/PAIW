<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Utilisateurs';

    protected static ?string $navigationLabel = 'Utilisateurs';

    protected static ?string $modelLabel = 'Utilisateur';

    protected static ?string $pluralModelLabel = 'Utilisateurs';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Avatar')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('avatar')
                            ->collection('avatar')
                            ->image()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('150')
                            ->imageResizeTargetHeight('150')
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])
                            ->columnSpanFull()
                            ->disk('public')
                            ->visibility('public')
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Informations personnelles')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nom d\'utilisateur')
                            ->required(),
                        Forms\Components\TextInput::make('first_name')
                            ->label('Prénom')
                            ->required(),
                        Forms\Components\TextInput::make('last_name')
                            ->label('Nom')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required(),
                        Forms\Components\DateTimePicker::make('email_verified_at')
                            ->label('Email vérifié le'),
                        Forms\Components\TextInput::make('password')
                            ->label('Mot de passe')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Adresse')
                    ->schema([
                        Forms\Components\TextInput::make('street')
                            ->label('Rue')
                            ->required(),
                        Forms\Components\TextInput::make('postal_code')
                            ->label('Code postal')
                            ->required(),
                        Forms\Components\TextInput::make('department')
                            ->label('Département')
                            ->required(),
                        Forms\Components\TextInput::make('country')
                            ->label('Pays')
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->label('Avatar')
                    ->getStateUsing(function (User $record): ?string {
                        return $record->getAvatarUrl();
                    })
                    ->defaultImageUrl(function (User $record): string {
                        return "https://ui-avatars.com/api/?name=" . urlencode($record->name) . "&size=40&background=6366f1&color=ffffff";
                    })
                    ->circular()
                    ->size(40),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom d\'utilisateur')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Nom complet')
                    ->getStateUsing(function (User $record): string {
                        return $record->first_name . ' ' . $record->last_name;
                    })
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('department')
                    ->label('Département')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('country')
                    ->label('Pays')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('email_verified_at')
                    ->label('Email vérifié')
                    ->boolean()
                    ->getStateUsing(fn (User $record): bool => $record->email_verified_at !== null)
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Modifié le')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('email_verified_at')
                    ->label('Email vérifié')
                    ->nullable(),
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
                Infolists\Components\Section::make('👤 Avatar')
                    ->description('Photo de profil de l\'utilisateur')
                    ->schema([
                        Infolists\Components\ImageEntry::make('avatar')
                            ->getStateUsing(function (User $record): ?string {
                                return $record->getAvatarThumbUrl();
                            })
                            ->defaultImageUrl(function (User $record): string {
                                return "https://ui-avatars.com/api/?name=" . urlencode($record->name) . "&size=150&background=6366f1&color=ffffff";
                            })
                            ->circular()
                            ->size(150),
                    ])
                    ->columns(1)
                    ->collapsible(),

                Infolists\Components\Section::make('📝 Informations personnelles')
                    ->description('Données de base de l\'utilisateur')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->label('👤 Nom d\'utilisateur')
                            ->weight('bold')
                            ->size('lg')
                            ->icon('heroicon-o-user'),
                        Infolists\Components\TextEntry::make('first_name')
                            ->label('🙋‍♂️ Prénom')
                            ->placeholder('Non renseigné'),
                        Infolists\Components\TextEntry::make('last_name')
                            ->label('👨‍💼 Nom')
                            ->placeholder('Non renseigné'),
                        Infolists\Components\TextEntry::make('email')
                            ->label('📧 Email')
                            ->icon('heroicon-m-envelope')
                            ->copyable()
                            ->copyMessage('Email copié!'),
                        Infolists\Components\TextEntry::make('email_verified_at')
                            ->label('✅ Email vérifié le')
                            ->dateTime('d/m/Y à H:i')
                            ->placeholder('❌ Non vérifié')
                            ->color(fn ($state) => $state ? 'success' : 'danger'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Infolists\Components\Section::make('📍 Adresse')
                    ->description('Informations de localisation')
                    ->schema([
                        Infolists\Components\TextEntry::make('street')
                            ->label('🏠 Rue')
                            ->placeholder('Non renseignée'),
                        Infolists\Components\TextEntry::make('postal_code')
                            ->label('📮 Code postal')
                            ->placeholder('Non renseigné'),
                        Infolists\Components\TextEntry::make('department')
                            ->label('🗺️ Département')
                            ->placeholder('Non renseigné'),
                        Infolists\Components\TextEntry::make('country')
                            ->label('🌍 Pays')
                            ->placeholder('Non renseigné'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Infolists\Components\Section::make('⚙️ Informations système')
                    ->description('Données techniques et historique')
                    ->schema([
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('📅 Créé le')
                            ->dateTime('d/m/Y à H:i')
                            ->icon('heroicon-o-calendar'),
                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('🔄 Modifié le')
                            ->dateTime('d/m/Y à H:i')
                            ->icon('heroicon-o-clock'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
