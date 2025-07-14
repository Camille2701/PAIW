<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use App\Models\ProductVariant;

class ProductVariantSeeder extends Seeder
{
    public function run(): void
    {
        // Supprimer les variants existants
        ProductVariant::truncate();

        $products = Product::all();
        $colors = Color::all();
        $sizes = Size::orderByRaw("CASE
            WHEN label = 'XS' THEN 1
            WHEN label = 'S' THEN 2
            WHEN label = 'M' THEN 3
            WHEN label = 'L' THEN 4
            WHEN label = 'XL' THEN 5
            WHEN label = 'XXL' THEN 6
            ELSE 7 END")->get();

        // Définir des combinaisons de tailles réalistes pour plus de variété
        $sizeVariations = [
            ['XS', 'S', 'M'],           // Petites tailles
            ['S', 'M', 'L'],            // Tailles moyennes
            ['M', 'L', 'XL'],           // Tailles standard
            ['L', 'XL', 'XXL'],         // Grandes tailles
            ['XS', 'M', 'XL'],          // Mélange dispersé
            ['S', 'L'],                 // Seulement 2 tailles
            ['XS', 'S', 'M', 'L'],      // Large gamme petite-moyenne
            ['S', 'M', 'L', 'XL'],      // Large gamme moyenne-grande
        ];

        foreach ($products as $product) {
            // Sélectionner 2-4 couleurs aléatoires pour ce produit
            $productColors = $colors->random(rand(2, 4));

            foreach ($productColors as $colorIndex => $color) {
                // Pour chaque couleur, choisir une variation de tailles différente
                $selectedVariation = $sizeVariations[array_rand($sizeVariations)];

                // Convertir les labels en objets Size
                $availableSizes = $sizes->whereIn('label', $selectedVariation);

                foreach ($availableSizes as $size) {
                    // Stock aléatoire : 70% de chance d'avoir du stock, 30% de rupture
                    $hasStock = rand(1, 100) <= 70;
                    $stock = $hasStock ? rand(1, 20) : 0;

                    ProductVariant::create([
                        'product_id' => $product->id,
                        'color_id' => $color->id,
                        'size_id' => $size->id,
                        'stock' => $stock,
                    ]);
                }
            }
        }

        $this->command->info('Product variants créés avec des stocks réalistes et des tailles variées !');
        $this->command->info('- Chaque produit a 2-4 couleurs disponibles');
        $this->command->info('- Chaque couleur a des tailles différentes et variées');
        $this->command->info('- 70% des variants ont du stock, 30% sont en rupture');
        $this->command->info('- Exemple : Violet (XS,S,M) / Rouge (L,XL) / Bleu (S,M,L,XL)');
    }
}
