<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Indomie Goreng',
            'barcode' => '8992388111111',
            'price' => 3500,
            'stock' => 120,
        ]);

        Product::create([
            'name' => 'Aqua 600ml',
            'barcode' => '8992388222222',
            'price' => 4000,
            'stock' => 90,
        ]);

        Product::create([
            'name' => 'Teh Botol',
            'barcode' => '8992388333333',
            'price' => 5000,
            'stock' => 75,
        ]);

        Product::create([
            'name' => 'Beras 5Kg',
            'barcode' => '8992388444444',
            'price' => 68000,
            'stock' => 30,
        ]);

        Product::create([
            'name' => 'Minyak Goreng',
            'barcode' => '8992388555555',
            'price' => 18000,
            'stock' => 40,
        ]);
    }
}