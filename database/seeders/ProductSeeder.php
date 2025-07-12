<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductType;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les types de produits existants
        $vestes = ProductType::where('name', 'Vestes')->first();
        $pantalons = ProductType::where('name', 'Pantalons')->first();
        $robes = ProductType::where('name', 'Robes')->first();

        // Créer des produits pour hommes (comme dans votre wireframe)
        $products = [
            [
                'name' => 'Veste d\'hiver pour homme',
                'description' => 'Veste chaude et élégante parfaite pour l\'hiver',
                'price' => 99.99,
                'product_type_id' => $vestes?->id ?? 1,
            ],
            [
                'name' => 'Veste d\'hiver pour homme',
                'description' => 'Modèle différent de veste d\'hiver',
                'price' => 99.99,
                'product_type_id' => $vestes?->id ?? 1,
            ],
            [
                'name' => 'Veste d\'hiver pour homme',
                'description' => 'Troisième modèle de veste d\'hiver',
                'price' => 99.99,
                'product_type_id' => $vestes?->id ?? 1,
            ],
            [
                'name' => 'Veste d\'hiver pour homme',
                'description' => 'Quatrième modèle de veste d\'hiver',
                'price' => 99.99,
                'product_type_id' => $vestes?->id ?? 1,
            ],
            [
                'name' => 'Veste d\'hiver pour homme',
                'description' => 'Cinquième modèle de veste d\'hiver',
                'price' => 99.99,
                'product_type_id' => $vestes?->id ?? 1,
            ],
            [
                'name' => 'Veste d\'hiver pour homme',
                'description' => 'Sixième modèle de veste d\'hiver',
                'price' => 99.99,
                'product_type_id' => $vestes?->id ?? 1,
            ],
            // Ajouter d'autres types de produits
            [
                'name' => 'Pantalon vintage homme',
                'description' => 'Pantalon rétro de qualité',
                'price' => 65.99,
                'product_type_id' => $pantalons?->id ?? 2,
            ],
            [
                'name' => 'Robe vintage femme',
                'description' => 'Belle robe vintage pour femme',
                'price' => 89.99,
                'product_type_id' => $robes?->id ?? 3,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
