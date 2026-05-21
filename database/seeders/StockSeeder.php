<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StockMovement;
use App\Models\Product;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        foreach ($products as $product) {

            StockMovement::create([
                'product_id' => $product->id,
                'type' => 'in',
                'qty' => $product->stock,
                'notes' => 'Stock awal',
            ]);

        }
    }
}