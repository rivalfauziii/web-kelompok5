<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        Branch::create([
            'name' => 'Cabang Utama',
            'address' => 'Jl. Sudirman No. 1',
            'city' => 'Jakarta'
        ]);
        Branch::create([
            'name' => 'Cabang Kedua',
            'address' => 'Kp Ciburial',
            'city' => 'Cianjur'
        ]);
    }
}