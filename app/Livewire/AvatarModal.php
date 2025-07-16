<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

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

        // Supprimer l'ancien avatar s'il existe
        $user->clearMediaCollection('avatar');

        // Ajouter le nouveau avatar
        $user->addMedia($this->avatar->getRealPath())
             ->usingFileName($this->avatar->getClientOriginalName())
             ->toMediaCollection('avatar');

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
