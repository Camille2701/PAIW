<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Color;
use App\Models\Size;
use App\Models\ProductVariant;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les types de produits, couleurs et tailles
        $menTypes = ProductType::where('gender', 'men')->get();
        $womenTypes = ProductType::where('gender', 'women')->get();
        $unisexTypes = ProductType::where('gender', 'unisex')->get();
        $colors = Color::all();
        $sizes = Size::all();

        // Produits pour hommes
        $menProducts = [
            ['name' => 'T-shirt Basic', 'type' => 'T-shirt', 'price' => 19.99],
            ['name' => 'T-shirt Premium', 'type' => 'T-shirt', 'price' => 29.99],
            ['name' => 'T-shirt Graphique', 'type' => 'T-shirt', 'price' => 24.99],
            ['name' => 'Sweat à Capuche', 'type' => 'Sweat', 'price' => 49.99],
            ['name' => 'Sweat Col Rond', 'type' => 'Sweat', 'price' => 44.99],
            ['name' => 'Veste Polaire', 'type' => 'Veste polaire', 'price' => 69.99],
            ['name' => 'Veste Outdoor', 'type' => 'Veste polaire', 'price' => 79.99],
            ['name' => 'Pantalon Chino', 'type' => 'Pantalon', 'price' => 59.99],
            ['name' => 'Pantalon Cargo', 'type' => 'Pantalon', 'price' => 64.99],
            ['name' => 'Jean Slim', 'type' => 'Jeans', 'price' => 74.99],
            ['name' => 'Jean Regular', 'type' => 'Jeans', 'price' => 69.99],
            ['name' => 'Chemise Classique', 'type' => 'Chemise', 'price' => 54.99],
            ['name' => 'Chemise Carreaux', 'type' => 'Chemise', 'price' => 49.99],
            ['name' => 'Pull Laine', 'type' => 'Pull', 'price' => 89.99],
            ['name' => 'Pull Col V', 'type' => 'Pull', 'price' => 79.99],
        ];

        // Produits pour femmes
        $womenProducts = [
            ['name' => 'T-shirt Coton Bio', 'type' => 'T-shirt', 'price' => 22.99],
            ['name' => 'T-shirt Vintage', 'type' => 'T-shirt', 'price' => 26.99],
            ['name' => 'Blouse Soie', 'type' => 'Blouse', 'price' => 89.99],
            ['name' => 'Blouse Fleurie', 'type' => 'Blouse', 'price' => 64.99],
            ['name' => 'Robe d\'Été', 'type' => 'Robe', 'price' => 79.99],
            ['name' => 'Robe de Soirée', 'type' => 'Robe', 'price' => 129.99],
            ['name' => 'Robe Midi', 'type' => 'Robe', 'price' => 94.99],
            ['name' => 'Jupe Plissée', 'type' => 'Jupe', 'price' => 49.99],
            ['name' => 'Jupe Crayon', 'type' => 'Jupe', 'price' => 54.99],
            ['name' => 'Pantalon Tailleur', 'type' => 'Pantalon', 'price' => 74.99],
            ['name' => 'Pantalon Large', 'type' => 'Pantalon', 'price' => 69.99],
            ['name' => 'Jean Skinny', 'type' => 'Jeans', 'price' => 79.99],
            ['name' => 'Jean Mom', 'type' => 'Jeans', 'price' => 84.99],
            ['name' => 'Pull Cachemire', 'type' => 'Pull', 'price' => 149.99],
            ['name' => 'Pull Oversize', 'type' => 'Pull', 'price' => 64.99],
            ['name' => 'Cardigan Long', 'type' => 'Cardigan', 'price' => 94.99],
            ['name' => 'Cardigan Court', 'type' => 'Cardigan', 'price' => 79.99],
            ['name' => 'Veste Blazer', 'type' => 'Veste', 'price' => 119.99],
            ['name' => 'Veste Jean', 'type' => 'Veste', 'price' => 89.99],
        ];

        // Produits unisexes
        $unisexProducts = [
            ['name' => 'Hoodie Essential', 'type' => 'Hoodie', 'price' => 59.99],
            ['name' => 'Hoodie Oversize', 'type' => 'Hoodie', 'price' => 64.99],
            ['name' => 'Sweat-shirt Classic', 'type' => 'Sweat-shirt', 'price' => 49.99],
            ['name' => 'Sweat-shirt Vintage', 'type' => 'Sweat-shirt', 'price' => 54.99],
            ['name' => 'T-shirt Oversize Basic', 'type' => 'T-shirt oversize', 'price' => 29.99],
            ['name' => 'T-shirt Oversize Premium', 'type' => 'T-shirt oversize', 'price' => 32.99],
            ['name' => 'Jogger Comfort', 'type' => 'Jogger', 'price' => 39.99],
            ['name' => 'Jogger Sport', 'type' => 'Jogger', 'price' => 44.99],
            ['name' => 'Short Basic', 'type' => 'Short', 'price' => 24.99],
            ['name' => 'Short Cargo', 'type' => 'Short', 'price' => 34.99],
            ['name' => 'Casquette Baseball', 'type' => 'Casquette', 'price' => 19.99],
            ['name' => 'Casquette Snapback', 'type' => 'Casquette', 'price' => 24.99],
            ['name' => 'Bonnet Laine', 'type' => 'Bonnet', 'price' => 14.99],
            ['name' => 'Bonnet Beanie', 'type' => 'Bonnet', 'price' => 16.99],
            ['name' => 'Chaussettes Pack 3', 'type' => 'Chaussettes', 'price' => 12.99],
            ['name' => 'Chaussettes Sport', 'type' => 'Chaussettes', 'price' => 9.99],
        ];

        // Créer les produits pour hommes
        foreach ($menProducts as $productData) {
            $type = $menTypes->where('name', $productData['type'])->first();
            if ($type) {
                $product = Product::create([
                    'name' => $productData['name'],
                    'description' => 'Description de ' . $productData['name'],
                    'price' => $productData['price'],
                    'product_type_id' => $type->id,
                ]);

                // Créer des variantes avec différentes couleurs et tailles
                $this->createVariants($product, $colors, $sizes);
            }
        }

        // Créer les produits pour femmes
        foreach ($womenProducts as $productData) {
            $type = $womenTypes->where('name', $productData['type'])->first();
            if ($type) {
                $product = Product::create([
                    'name' => $productData['name'],
                    'description' => 'Description de ' . $productData['name'],
                    'price' => $productData['price'],
                    'product_type_id' => $type->id,
                ]);

                // Créer des variantes avec différentes couleurs et tailles
                $this->createVariants($product, $colors, $sizes);
            }
        }

        // Créer les produits unisexes
        foreach ($unisexProducts as $productData) {
            $type = $unisexTypes->where('name', $productData['type'])->first();
            if ($type) {
                $product = Product::create([
                    'name' => $productData['name'],
                    'description' => 'Description de ' . $productData['name'] . ' - Article unisexe convenant aux hommes et aux femmes.',
                    'price' => $productData['price'],
                    'product_type_id' => $type->id,
                ]);

                // Créer des variantes avec différentes couleurs et tailles
                $this->createVariants($product, $colors, $sizes);
            }
        }
    }

    private function createVariants($product, $colors, $sizes)
    {
        // Prendre 3-5 couleurs aléatoires pour chaque produit
        $selectedColors = $colors->random(rand(3, 5));
        // Prendre 4-6 tailles aléatoires pour chaque produit
        $selectedSizes = $sizes->random(rand(4, 6));

        foreach ($selectedColors as $color) {
            foreach ($selectedSizes as $size) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'size_id' => $size->id,
                    'color_id' => $color->id,
                    'stock' => rand(5, 50), // Stock aléatoire entre 5 et 50
                ]);
            }
        }
    }
}
