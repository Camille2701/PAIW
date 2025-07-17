<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\SizeSeeder;
use Database\Seeders\ColorSeeder;
use Database\Seeders\ProductTypeSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Pour SQLite, on utilise PRAGMA foreign_keys au lieu de SET FOREIGN_KEY_CHECKS
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=OFF;');
        } else {
            // Désactiver les vérifications de clés étrangères pour MySQL
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        // Vider d'abord les tables qui ont des clés étrangères vers d'autres tables
        // Cela évite les erreurs de contraintes lors du truncate
        DB::table('cart_items')->delete();
        DB::table('order_items')->delete();

        $this->call([
            SizeSeeder::class,
            ColorSeeder::class,
            ProductTypeSeeder::class,
            ProductSeeder::class,
            ProductVariantSeeder::class,
        ]);

        // Réactiver les vérifications de clés étrangères
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=ON;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
