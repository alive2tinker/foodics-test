<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ingredient::create([
            'name' => "Beef",
            'currentStock' => 20000,
            'topStock' => 20000
        ]);
        Ingredient::create([
            'name' => "Cheese",
            'currentStock' => 5000,
            'topStock' => 5000
        ]);
        Ingredient::create([
            'name' => "Onion",
            'currentStock' => 1000,
            'topStock' => 1000
        ]);
    }
}
