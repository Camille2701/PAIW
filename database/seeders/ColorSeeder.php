<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('colors')->insert([
            ['name' => 'noir'],
            ['name' => 'blanc'],
            ['name' => 'rouge'],
            ['name' => 'bleu'],
            ['name' => 'gris'],
            ['name' => 'jaune'],
            ['name' => 'violet'],
        ]);
    }
}
