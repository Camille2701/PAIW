<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Header extends Component
{
    public $searchQuery = '';
    public $showSearchModal = false;
    public $showUserMenu = false;

    public function search()
    {
        if (empty($this->searchQuery)) {
            return;
        }

        // Si on est sur la page d'accueil, afficher une modal
        if (request()->is('/')) {
            $this->showSearchModal = true;
        } else {
            // Sinon, rediriger vers la page shop avec la recherche
            return redirect('/shop/men?search=' . urlencode($this->searchQuery));
        }
    }

    public function goToShop()
    {
        if (!empty($this->searchQuery)) {
            return redirect('/shop/men?search=' . urlencode($this->searchQuery));
        }
        return redirect('/shop/men');
    }

    public function closeModal()
    {
        $this->showSearchModal = false;
        $this->searchQuery = '';
    }

    public function toggleUserMenu()
    {
        $this->showUserMenu = !$this->showUserMenu;
    }

    public function closeUserMenu()
    {
        $this->showUserMenu = false;
    }

    public function render()
    {
        return view('livewire.components.header');
    }
}
