<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('colors')->insert([
            ['name' => 'Orange', 'hex_code' => '#f97316'],
            ['name' => 'Violet', 'hex_code' => '#9333ea'],
            ['name' => 'Bleu', 'hex_code' => '#2563eb'],
            ['name' => 'Vert', 'hex_code' => '#16a34a'],
            ['name' => 'Teal', 'hex_code' => '#0d9488'],
            ['name' => 'Rouge', 'hex_code' => '#dc2626'],
            ['name' => 'Cyan', 'hex_code' => '#06b6d4'],
            ['name' => 'Noir', 'hex_code' => '#374151'],
            ['name' => 'Rose', 'hex_code' => '#ec4899'],
            ['name' => 'Lime', 'hex_code' => '#65a30d'],
        ]);
    }
}
