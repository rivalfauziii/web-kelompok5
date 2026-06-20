<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [1, 2, 3, 4, 5];

        foreach ($branches as $branchId) {

            Product::create([
                'branch_id' => $branchId,
                'name' => 'Indomie Goreng',
                'barcode' => '8992388111111-' . $branchId,
                'price' => 3500,
                'stock' => 120,
                'image' => 'products/INDOMIE-GORENG-SPECIAL-85G.png',
            ]);

            Product::create([
                'branch_id' => $branchId,
                'name' => 'Aqua 600ml',
                'barcode' => '8992388222222-' . $branchId,
                'price' => 4000,
                'stock' => 90,
                'image' => 'products/aqua.jpg',
            ]);

            Product::create([
                'branch_id' => $branchId,
                'name' => 'Teh Botol',
                'barcode' => '8992388333333-' . $branchId,
                'price' => 5000,
                'stock' => 75,
                'image' => 'products/logo-teh-botol-sosro-png-17.png',
            ]);

            Product::create([
                'branch_id' => $branchId,
                'name' => 'Beras 5Kg',
                'barcode' => '8992388444444-' . $branchId,
                'price' => 68000,
                'stock' => 30,
                'image' => 'products/beras.jpg',
            ]);

            Product::create([
                'branch_id' => $branchId,
                'name' => 'Minyak Goreng',
                'barcode' => '8992388555555-' . $branchId,
                'price' => 18000,
                'stock' => 40,
                'image' => 'products/minyak.jpg',
            ]);
        }
    }
}