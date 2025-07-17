<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class HeaderComponent extends Component
{
    public $search = '';
    public $showSearchModal = false;
    public $showUserMenu = false;

    public function searchAction()
    {
        if (empty($this->search)) {
            return;
        }

        // Rechercher dans les deux genres avec priorité aux correspondances exactes
        $exactMatch = Product::with(['productType'])
            ->where('name', 'like', $this->search)
            ->first();

        if ($exactMatch) {
            // Correspondance exacte trouvée
            $gender = $exactMatch->productType->gender;
            $route = $gender === 'women' ? 'shop.women' : 'shop.men';
            return redirect()->route($route, ['search' => $this->search]);
        }

        // Rechercher des correspondances partielles
        $partialMatch = Product::with(['productType'])
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderByRaw("CASE WHEN name LIKE ? THEN 1 ELSE 2 END", [$this->search . '%']) // Priorité aux mots qui commencent par la recherche
            ->first();

        if ($partialMatch) {
            // Correspondance partielle trouvée
            $gender = $partialMatch->productType->gender;
            $route = $gender === 'women' ? 'shop.women' : 'shop.men';
            return redirect()->route($route, ['search' => $this->search]);
        }

        // Si aucun produit n'est trouvé, rediriger vers la page homme par défaut avec un message
        return redirect()->route('shop.men', ['search' => $this->search]);
    }

    public function goToShop()
    {
        // Utiliser la même logique de recherche intelligente
        return $this->searchAction();
    }

    public function closeModal()
    {
        $this->showSearchModal = false;
        $this->search = '';
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
        return view('livewire.header-component');
    }
}
