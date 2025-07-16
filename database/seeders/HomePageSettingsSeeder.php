<?php

namespace Database\Seeders;

use App\Models\HomePageSettings;
use Illuminate\Database\Seeder;

class HomePageSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer l'entrée unique pour les paramètres de la page d'accueil
        HomePageSettings::firstOrCreate([]);
    }
}
