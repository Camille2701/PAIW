<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class HeaderComponent extends Component
{
    public $searchQuery = '';
    public $showSearchModal = false;
    public $showUserMenu = false;
    public $showMobileMenu = false;

    public function searchAction()
    {
        if (empty($this->searchQuery)) {
            return;
        }

        // Rechercher dans les deux genres avec priorité aux correspondances exactes
        $exactMatch = Product::with(['productType'])
            ->where('name', 'like', $this->searchQuery)
            ->first();

        if ($exactMatch) {
            // Correspondance exacte trouvée
            $gender = $exactMatch->productType->gender;
            $route = $gender === 'women' ? 'shop.women' : 'shop.men';
            return redirect()->route($route, ['search' => $this->searchQuery]);
        }

        // Rechercher des correspondances partielles
        $partialMatch = Product::with(['productType'])
            ->where('name', 'like', '%' . $this->searchQuery . '%')
            ->orderByRaw("CASE WHEN name LIKE ? THEN 1 ELSE 2 END", [$this->searchQuery . '%']) // Priorité aux mots qui commencent par la recherche
            ->first();

        if ($partialMatch) {
            // Correspondance partielle trouvée
            $gender = $partialMatch->productType->gender;
            $route = $gender === 'women' ? 'shop.women' : 'shop.men';
            return redirect()->route($route, ['search' => $this->searchQuery]);
        }

        // Si aucun produit n'est trouvé, rediriger vers la page homme par défaut avec un message
        return redirect()->route('shop.men', ['search' => $this->searchQuery]);
    }

    public function goToShop()
    {
        // Utiliser la même logique de recherche intelligente
        return $this->searchAction();
    }

    public function search()
    {
        // Méthode appelée par wire:keydown.enter="search"
        return $this->searchAction();
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

    public function toggleMobileMenu()
    {
        $this->showMobileMenu = !$this->showMobileMenu;
    }

    public function closeMobileMenu()
    {
        $this->showMobileMenu = false;
    }

    public function render()
    {
        return view('livewire.components.header');
    }
}
