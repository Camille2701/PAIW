<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Header extends Component
{
    public $searchQuery = '';

    public function search()
    {
        // Logique de recherche à implémenter
        $this->dispatch('search-performed', $this->searchQuery);
    }

    public function render()
    {
        return view('livewire.components.header');
    }
}
