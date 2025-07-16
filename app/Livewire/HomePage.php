<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class HomePage extends Component
{
    public $featuredProducts = [];
    public $newArrivals = [];

    public function mount()
    {
        // Récupérer les 3 produits les plus récents pour "Nos derniers arrivages"
        $this->newArrivals = Product::with(['productType'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Récupérer 3 produits aléatoires pour "Nos coups de cœur"
        $this->featuredProducts = Product::with(['productType'])
            ->inRandomOrder()
            ->take(3)
            ->get();

        // Si nous n'avons pas assez de produits, utilisez des données de simulation
        if ($this->newArrivals->isEmpty()) {
            $this->newArrivals = collect([
                (object)['name' => 'Veste Vintage', 'price' => 89.00, 'slug' => 'veste-vintage', 'productType' => (object)['gender' => 'men']],
                (object)['name' => 'Robe Rétro', 'price' => 65.00, 'slug' => 'robe-retro', 'productType' => (object)['gender' => 'women']],
                (object)['name' => 'Pantalon Vintage', 'price' => 45.00, 'slug' => 'pantalon-vintage', 'productType' => (object)['gender' => 'men']],
            ]);
        }

        if ($this->featuredProducts->isEmpty()) {
            $this->featuredProducts = collect([
                (object)['name' => 'Chemise Vintage', 'price' => 55.00, 'slug' => 'chemise-vintage', 'productType' => (object)['gender' => 'men']],
                (object)['name' => 'Jupe Rétro', 'price' => 40.00, 'slug' => 'jupe-retro', 'productType' => (object)['gender' => 'women']],
                (object)['name' => 'Pull Vintage', 'price' => 70.00, 'slug' => 'pull-vintage', 'productType' => (object)['gender' => 'women']],
            ]);
        }
    }

    public function render()
    {
        return view('livewire.home-page')->layout('layouts.app');
    }
}
