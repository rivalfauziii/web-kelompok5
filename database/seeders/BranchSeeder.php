<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        Branch::create([
            'name' => 'Cabang Jakarta',
            'city' => 'Jakarta',
            'address' => 'Jl. Sudirman'
        ]);

        Branch::create([
            'name' => 'Cabang Bandung',
            'city' => 'Bandung',
            'address' => 'Jl. Asia Afrika'
        ]);

        Branch::create([
            'name' => 'Cabang Surabaya',
            'city' => 'Surabaya',
            'address' => 'Jl. Darmo'
        ]);

        Branch::create([
            'name' => 'Cabang Medan',
            'city' => 'Medan',
            'address' => 'Jl. Gatot Subroto'
        ]);

        Branch::create([
            'name' => 'Cabang Makassar',
            'city' => 'Makassar',
            'address' => 'Jl. Pettarani'
        ]);
    }
}