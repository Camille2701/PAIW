<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Color;

class ShopPage extends Component
{
    use WithPagination;

    // Propriétés pour les filtres
    public $selectedCategories = [];
    public $selectedColors = [];
    public $sortBy = 'popular';
    public $search = '';

    // Propriétés pour l'affichage
    public $showFilters = true;
    public $perPage = 6;

    // Méthode pour charger plus de produits
    public function loadMore()
    {
        $this->perPage += 6;
    }

    // Reset pagination quand les filtres changent
    public function updatedSelectedCategories()
    {
        $this->resetPage();
        $this->perPage = 6;
    }

    public function updatedSelectedColors()
    {
        $this->resetPage();
        $this->perPage = 6;
    }

    public function updatedSortBy()
    {
        $this->resetPage();
        $this->perPage = 6;
    }

    public function updatedSearch()
    {
        $this->resetPage();
        $this->perPage = 6;
    }

    public function clearFilters()
    {
        $this->selectedCategories = [];
        $this->selectedColors = [];
        $this->resetPage();
    }

    public function toggleColor($color)
    {
        if (in_array($color, $this->selectedColors)) {
            $this->selectedColors = array_diff($this->selectedColors, [$color]);
        } else {
            $this->selectedColors[] = $color;
        }
        $this->resetPage();
    }

    public function render()
    {
        $query = Product::with(['productType', 'variants.size', 'variants.color']);

        // Filtrer par catégories
        if (!empty($this->selectedCategories)) {
            $query->whereIn('product_type_id', $this->selectedCategories);
        }

        // Filtrer par recherche
        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        // Tri
        switch ($this->sortBy) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'popular':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Récupérer les produits avec pagination
        $allProducts = $query->get();
        $products = $allProducts->take($this->perPage);
        $hasMoreProducts = $allProducts->count() > $this->perPage;

        $productTypes = ProductType::all();
        $colors = Color::all();

        return view('livewire.shop-page', [
            'products' => $products,
            'productTypes' => $productTypes,
            'colors' => $colors,
            'hasMoreProducts' => $hasMoreProducts,
        ])->layout('layouts.app');
    }
}
