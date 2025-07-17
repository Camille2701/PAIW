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
    public $colorFilterType = 'ou'; // 'ou' ou 'et'
    public $sortBy = 'popular';
    public $search = '';
    public $gender = 'men'; // Par défaut on affiche les vêtements pour hommes

    // Propriétés pour l'affichage
    public $showFilters = true;
    public $perPage = 6;

    public function mount()
    {
        // Si on a une recherche dans l'URL, on la récupère
        if (request('search')) {
            $this->search = request('search');
        }

        // Si on a un genre dans l'URL, on le récupère
        if (request('gender')) {
            $this->gender = request('gender');
        }

        // Détecter automatiquement le genre selon la route
        if (request()->is('shop/women*')) {
            $this->gender = 'women';
        } elseif (request()->is('shop/men*')) {
            $this->gender = 'men';
        }
    }

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

    public function updatedColorFilterType()
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

    public function updatedGender()
    {
        $this->selectedCategories = []; // Reset les catégories quand on change de genre
        $this->selectedColors = []; // Reset les couleurs aussi
        $this->colorFilterType = 'ou'; // Reset le type de filtre couleur
        $this->resetPage();
        $this->perPage = 6;

        // Redirection vers la bonne URL
        $url = $this->gender === 'women' ? '/shop/women' : '/shop/men';
        if (!empty($this->search)) {
            $url .= '?search=' . urlencode($this->search);
        }

        return redirect($url);
    }

    public function switchGender($newGender)
    {
        $this->gender = $newGender;
        $this->selectedCategories = [];
        $this->selectedColors = [];
        $this->colorFilterType = 'ou';
        $this->resetPage();
        $this->perPage = 6;

        // Redirection vers la bonne URL
        $url = $newGender === 'women' ? '/shop/women' : '/shop/men';
        if (!empty($this->search)) {
            $url .= '?search=' . urlencode($this->search);
        }

        return redirect($url);
    }

    public function clearFilters()
    {
        $this->selectedCategories = [];
        $this->selectedColors = [];
        $this->colorFilterType = 'ou';
        $this->search = '';
        $this->resetPage();
    }

    public function toggleColor($colorId)
    {
        if (in_array($colorId, $this->selectedColors)) {
            $this->selectedColors = array_diff($this->selectedColors, [$colorId]);
        } else {
            $this->selectedColors[] = $colorId;
        }
        $this->resetPage();
    }

    public function render()
    {
        $query = Product::with(['productType', 'variants.size', 'variants.color']);

        // Filtrer par genre (inclure les produits unisexes)
        $query->whereHas('productType', function($q) {
            $q->where('gender', $this->gender)->orWhere('gender', 'unisex');
        });

        // Filtrer par catégories
        if (!empty($this->selectedCategories)) {
            $query->whereIn('product_type_id', $this->selectedCategories);
        }

        // Filtrer par couleurs
        if (!empty($this->selectedColors)) {
            if ($this->colorFilterType === 'et') {
                // Filtrage ET : le produit doit avoir TOUTES les couleurs sélectionnées
                foreach ($this->selectedColors as $colorId) {
                    $query->whereHas('variants.color', function($q) use ($colorId) {
                        $q->where('colors.id', $colorId);
                    });
                }
            } else {
                // Filtrage OU : le produit doit avoir AU MOINS UNE des couleurs sélectionnées
                $query->whereHas('variants.color', function($q) {
                    $q->whereIn('colors.id', $this->selectedColors);
                });
            }
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

        // Récupérer les types de produits pour le genre sélectionné (inclure les unisexes)
        $productTypes = ProductType::where('gender', $this->gender)->orWhere('gender', 'unisex')->get();
        $colors = Color::all();

        return view('livewire.shop-page', [
            'products' => $products,
            'productTypes' => $productTypes,
            'colors' => $colors,
            'hasMoreProducts' => $hasMoreProducts,
        ])->layout('layouts.app');
    }
}
