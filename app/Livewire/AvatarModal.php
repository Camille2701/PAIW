<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AvatarModal extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $avatar;

    protected $listeners = ['openModal' => 'openModal'];

    protected $rules = [
        'avatar' => 'required|image|max:2048', // 2MB Max
    ];

    protected $messages = [
        'avatar.required' => 'Veuillez sélectionner une image.',
        'avatar.image' => 'Le fichier doit être une image.',
        'avatar.max' => 'L\'image ne doit pas dépasser 2MB.',
    ];

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->avatar = null;
        $this->resetValidation();
    }    public function uploadAvatar()
    {
        $user = Auth::user();

        // Vérifier si l'utilisateur est connecté
        if (!$user) {
            return $this->redirect('/login');
        }

        $this->validate();

        // Debug: Log les informations avant la sauvegarde
        Log::info('=== DÉBUT UPLOAD AVATAR ===');
        Log::info('User ID: ' . $user->id);
        Log::info('Fichier original: ' . $this->avatar->getClientOriginalName());
        Log::info('Taille fichier: ' . $this->avatar->getSize());

        // Supprimer l'ancien avatar s'il existe
        Log::info('Ancien avatar avant suppression:', $user->getMedia('avatar')->toArray());
        $user->clearMediaCollection('avatar');

        // Ajouter le nouveau avatar
        $media = $user->addMedia($this->avatar->getRealPath())
                     ->usingFileName($this->avatar->getClientOriginalName())
                     ->toMediaCollection('avatar');

        // Debug: Log les informations après la sauvegarde
        Log::info('Media créé:', $media->toArray());
        Log::info('URL générée par getFirstMediaUrl: ' . $user->getFirstMediaUrl('avatar'));
        Log::info('URL générée par getAvatarUrl: ' . $user->getAvatarUrl());
        Log::info('Fichier physique existe: ' . (file_exists(storage_path('app/public/' . $media->id . '/' . $media->file_name)) ? 'OUI' : 'NON'));
        Log::info('=== FIN UPLOAD AVATAR ===');

        $this->closeModal();

        // Message de succès
        session()->flash('success', 'Avatar mis à jour avec succès !');

        // Rafraîchir la page pour voir les changements
        return redirect()->route('profile');
    }

    public function render()
    {
        return view('livewire.avatar-modal');
    }
}
