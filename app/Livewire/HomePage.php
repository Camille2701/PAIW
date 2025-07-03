<?php

namespace App\Livewire;

use Livewire\Component;

class HomePage extends Component
{
    public $featuredProducts = [];
    public $newArrivals = [];

    public function mount()
    {
        // Simulation de données de produits - à remplacer par des vraies données
        $this->featuredProducts = [
            ['id' => 1, 'name' => 'Veste Vintage', 'price' => '89€', 'image' => '/images/placeholder1.jpg'],
            ['id' => 2, 'name' => 'Robe Rétro', 'price' => '65€', 'image' => '/images/placeholder2.jpg'],
            ['id' => 3, 'name' => 'Pantalon Vintage', 'price' => '45€', 'image' => '/images/placeholder3.jpg'],
        ];

        $this->newArrivals = [
            ['id' => 4, 'name' => 'Chemise Vintage', 'price' => '55€', 'image' => '/images/placeholder4.jpg'],
            ['id' => 5, 'name' => 'Jupe Rétro', 'price' => '40€', 'image' => '/images/placeholder5.jpg'],
            ['id' => 6, 'name' => 'Pull Vintage', 'price' => '70€', 'image' => '/images/placeholder6.jpg'],
        ];
    }

    public function render()
    {
        return view('livewire.home-page')->layout('layouts.app');
    }
}
