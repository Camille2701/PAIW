<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTypeSeeder extends Seeder
{    public function run(): void
    {
        DB::table('product_types')->insert([
            // Vêtements pour hommes
            ['name' => 'T-shirt', 'gender' => 'men'],
            ['name' => 'Sweat', 'gender' => 'men'],
            ['name' => 'Veste polaire', 'gender' => 'men'],
            ['name' => 'Pantalon', 'gender' => 'men'],
            ['name' => 'Jeans', 'gender' => 'men'],
            ['name' => 'Chemise', 'gender' => 'men'],
            ['name' => 'Pull', 'gender' => 'men'],

            // Vêtements pour femmes
            ['name' => 'T-shirt', 'gender' => 'women'],
            ['name' => 'Blouse', 'gender' => 'women'],
            ['name' => 'Robe', 'gender' => 'women'],
            ['name' => 'Jupe', 'gender' => 'women'],
            ['name' => 'Pantalon', 'gender' => 'women'],
            ['name' => 'Jeans', 'gender' => 'women'],
            ['name' => 'Pull', 'gender' => 'women'],
            ['name' => 'Cardigan', 'gender' => 'women'],
            ['name' => 'Veste', 'gender' => 'women'],
        ]);
    }
}
