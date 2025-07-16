<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use App\Services\CartService;
use Illuminate\Support\Facades\Log;

class ProductPage extends Component
{
    public Product $product;
    public $selectedColorId = null;
    public $selectedSizeId = null;
    public $quantity = 1;
    public $availableSizes;
    public $availableColors;
    public $currentVariant = null;    public function mount(Product $product, $color = null)
    {
        $this->product = $product->load(['variants.color', 'variants.size', 'productType']);

        // Récupérer toutes les couleurs disponibles pour ce produit
        $this->availableColors = $this->product->variants->pluck('color')->unique('id')->values();

        // Récupérer TOUTES les tailles (pas seulement celles du produit)
        $this->availableSizes = Size::orderByRaw("CASE
            WHEN label = 'XS' THEN 1
            WHEN label = 'S' THEN 2
            WHEN label = 'M' THEN 3
            WHEN label = 'L' THEN 4
            WHEN label = 'XL' THEN 5
            WHEN label = 'XXL' THEN 6
            ELSE 7 END")->get();

        // Récupérer le paramètre de couleur depuis la query string
        $colorParam = request()->query('color');

        // Définir la couleur par défaut avec une correspondance plus flexible
        if ($colorParam) {
            // Essayer d'abord par nom exact
            $colorModel = Color::where('name', 'LIKE', '%' . $colorParam . '%')->first();
            if (!$colorModel) {
                // Essayer par hex_code si c'est une couleur connue
                $colorMap = [
                    'cyan' => '#00bcd4',
                    'blue' => '#2196f3',
                    'violet' => '#9c27b0',
                    'purple' => '#9c27b0',
                    'red' => '#f44336',
                    'green' => '#4caf50',
                    'orange' => '#ff9800',
                    'black' => '#000000',
                    'white' => '#ffffff',
                    'gray' => '#9e9e9e'
                ];

                if (isset($colorMap[strtolower($colorParam)])) {
                    $colorModel = Color::where('hex_code', $colorMap[strtolower($colorParam)])->first();
                }
            }

            if ($colorModel && $this->availableColors->contains('id', $colorModel->id)) {
                $this->selectedColorId = $colorModel->id;
            }
        }

        // Si aucune couleur n'est sélectionnée, prendre la première couleur disponible
        if (!$this->selectedColorId && $this->availableColors->isNotEmpty()) {
            $this->selectedColorId = $this->availableColors->first()->id;
        }

        $this->updateCurrentVariant();
    }

    public function updatedSelectedColorId()
    {
        // Réinitialiser la sélection de taille quand on change de couleur
        $this->selectedSizeId = null;
        $this->updateCurrentVariant();
        $this->updateUrl();
    }

    // Propriété calculée pour l'image courante
    public function getCurrentImageUrlProperty()
    {
        return $this->getCurrentImage('large');
    }

    // Méthode pour obtenir l'image de la couleur sélectionnée
    public function getCurrentImage($conversion = 'large')
    {
        // S'assurer que selectedColorId est toujours défini
        if (!$this->selectedColorId && $this->availableColors->isNotEmpty()) {
            $this->selectedColorId = $this->availableColors->first()->id;
        }

        if ($this->selectedColorId) {
            $imageUrl = $this->product->getImageUrl($this->selectedColorId, $conversion);
            if ($imageUrl) {
                return $imageUrl;
            }
        }

        return $this->product->getDefaultImage($conversion);
    }

    // Méthode pour vérifier si une couleur a une image
    public function colorHasImage($colorId)
    {
        return $this->product->hasImageForColor($colorId);
    }

    public function updatedSelectedSizeId()
    {
        // S'assurer que la couleur reste sélectionnée
        if (!$this->selectedColorId && $this->availableColors->isNotEmpty()) {
            $this->selectedColorId = $this->availableColors->first()->id;
        }

        $this->updateCurrentVariant();
        // Ajuster la quantité si elle dépasse le stock disponible
        if ($this->currentVariant && $this->quantity > $this->currentVariant->stock) {
            $this->quantity = max(1, $this->currentVariant->stock);
        }
    }

    public function updatedQuantity()
    {
        // S'assurer que la quantité ne dépasse pas le stock disponible
        if ($this->currentVariant && $this->quantity > $this->currentVariant->stock) {
            $this->quantity = $this->currentVariant->stock;
        }
        // S'assurer que la quantité est au minimum 1
        if ($this->quantity < 1) {
            $this->quantity = 1;
        }
    }

    private function updateCurrentVariant()
    {
        if ($this->selectedColorId && $this->selectedSizeId) {
            $this->currentVariant = $this->product->variants
                ->where('color_id', $this->selectedColorId)
                ->where('size_id', $this->selectedSizeId)
                ->first();
        }
    }

    public function getProductPrice()
    {
        return $this->product->price ?? 0;
    }

    private function updateUrl()
    {
        if ($this->selectedColorId) {
            $color = Color::find($this->selectedColorId);
            $gender = $this->product->productType->gender === 'men' ? 'men' : 'women';
            $url = "/shop/{$gender}/{$this->product->slug}";

            if ($color) {
                $url .= "?color=" . strtolower($color->name);
            }

            $this->redirect($url, navigate: true);
        }
    }

    public function addToCart(CartService $cartService)
    {
        if (!$this->currentVariant) {
            session()->flash('error', 'Veuillez sélectionner une couleur et une taille.');
            return;
        }

        if ($this->currentVariant->stock < $this->quantity) {
            session()->flash('error', 'Stock insuffisant.');
            return;
        }

        try {
            // Ajouter au panier en utilisant le service
            $cartService->addToCart($this->currentVariant->id, $this->quantity);

            // Émettre un événement pour mettre à jour le compteur du panier
            $this->dispatch('cartUpdated');

            session()->flash('success', 'Produit ajouté au panier !');
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'ajout au panier: ' . $e->getMessage());
            session()->flash('error', 'Erreur lors de l\'ajout au panier.');
        }
    }

    public function isSizeAvailable($sizeId)
    {
        if (!$this->selectedColorId) {
            return false;
        }

        return $this->product->variants
            ->where('color_id', $this->selectedColorId)
            ->where('size_id', $sizeId)
            ->where('stock', '>', 0)
            ->isNotEmpty();
    }

    public function isInStock()
    {
        return $this->currentVariant && $this->currentVariant->stock > 0;
    }

    public function getRemainingStock()
    {
        return $this->currentVariant ? $this->currentVariant->stock : 0;
    }

    public function canAddToCart()
    {
        return $this->selectedColorId && $this->selectedSizeId && $this->isInStock();
    }

    // Méthode pour vérifier si la couleur sélectionnée a du stock
    public function isColorInStock()
    {
        if (!$this->selectedColorId) {
            return false;
        }

        return $this->product->variants
            ->where('color_id', $this->selectedColorId)
            ->where('stock', '>', 0)
            ->isNotEmpty();
    }

    public function render()
    {
        return view('livewire.product-page')
            ->layout('layouts.app');
    }
}
