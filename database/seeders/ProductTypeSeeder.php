<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('product_types')->insert([
            ['name' => 't-shirt'],
            ['name' => 'sweat'],
            ['name' => 'veste polaire'],
            ['name' => 'pantalon'],
            ['name' => 'jeans'],
        ]);
    }
}
