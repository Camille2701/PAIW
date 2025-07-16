<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $variants = ProductVariant::with(['product', 'color'])->get();

        foreach ($variants as $variant) {
            // Créer une image simple basée sur la couleur
            $this->createColorImage($variant);
        }
    }

    private function createColorImage($variant)
    {
        $colorCode = $variant->color->hex_code ?? '#cccccc';
        $productName = $variant->product->name ?? 'Product';

        // Créer une image simple avec GD
        $width = 800;
        $height = 800;

        // Créer l'image
        $image = imagecreate($width, $height);

        // Convertir le code hex en RGB
        $hex = str_replace('#', '', $colorCode);
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        // Couleurs
        $bgColor = imagecolorallocate($image, $r, $g, $b);
        $textColor = imagecolorallocate($image, 255, 255, 255);

        // Ajouter du texte simple
        $text = $productName . "\n" . $variant->color->name;
        imagestring($image, 5, $width/2 - 50, $height/2 - 10, $productName, $textColor);
        imagestring($image, 3, $width/2 - 30, $height/2 + 20, $variant->color->name, $textColor);

        // Sauvegarder temporairement
        $filename = "product_{$variant->id}_" . str_replace('#', '', $colorCode) . ".png";
        $tempPath = storage_path("app/temp/{$filename}");

        // Créer le dossier temp s'il n'existe pas
        if (!file_exists(dirname($tempPath))) {
            mkdir(dirname($tempPath), 0755, true);
        }

        // Sauvegarder l'image
        imagepng($image, $tempPath);
        imagedestroy($image);

        try {
            // Ajouter l'image au variant via Media Library
            $variant->addMedia($tempPath)
                    ->usingName("{$productName} - {$variant->color->name}")
                    ->usingFileName($filename)
                    ->toMediaCollection('images');

            // Supprimer le fichier temporaire
            unlink($tempPath);

            echo "Image créée pour {$productName} - {$variant->color->name}\n";
        } catch (\Exception $e) {
            echo "Erreur lors de l'ajout de l'image pour le variant {$variant->id}: " . $e->getMessage() . "\n";
        }
    }
}
