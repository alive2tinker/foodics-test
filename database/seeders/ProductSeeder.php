<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = Product::create([
            'name' => "Burger"
        ]);

        $product->ingredients()->create([
            'ingredient_id' => 1,
            'quantity' => 150
        ]);

        $product->ingredients()->create([
            'ingredient_id' => 2,
            'quantity' => 30
        ]);

        $product->ingredients()->create([
            'ingredient_id' => 3,
            'quantity' => 20
        ]);
    }
}
