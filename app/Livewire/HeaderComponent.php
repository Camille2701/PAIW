<?php

namespace App\Livewire;

use Livewire\Component;

class HeaderComponent extends Component
{
    public $search = '';
    public $showSearchModal = false;

    public function searchAction()
    {
        if (empty($this->search)) {
            return;
        }

        // Si on est sur la page d'accueil, afficher une modal
        if (request()->is('/')) {
            $this->showSearchModal = true;
        } else {
            // Sinon, rediriger vers la page shop avec la recherche
            return redirect()->route('shop', ['search' => $this->search]);
        }
    }

    public function goToShop()
    {
        return redirect()->route('shop', ['search' => $this->search]);
    }

    public function closeModal()
    {
        $this->showSearchModal = false;
        $this->search = '';
    }

    public function render()
    {
        return view('livewire.header-component');
    }
}
