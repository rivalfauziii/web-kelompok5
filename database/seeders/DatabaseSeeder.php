<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BranchSeeder::class,
            ProductSeeder::class,
            StockSeeder::class,
        ]);

        /*
        |--------------------------------------------------------------------------
        | OWNER
        |--------------------------------------------------------------------------
        */

        User::create([

            'name' => 'Owner Syakamarket',
            'email' => 'owner@syakamarket.com',
            'password' => Hash::make('password'),

            'role' => 'owner',

        ]);

        // =====================
// JAKARTA (ID 1)
// =====================

        User::create([
            'name' => 'Manager Jakarta',
            'email' => 'manager.jkt@syakamarket.com',
            'password' => Hash::make('password'),
            'branch_id' => 1,
            'role' => 'manager',
        ]);

        User::create([
            'name' => 'Supervisor Jakarta',
            'email' => 'supervisor.jkt@syakamarket.com',
            'password' => Hash::make('password'),
            'branch_id' => 1,
            'role' => 'supervisor',
        ]);

        User::create([
            'name' => 'Warehouse Jakarta',
            'email' => 'warehouse.jkt@syakamarket.com',
            'password' => Hash::make('password'),
            'branch_id' => 1,
            'role' => 'warehouse',
        ]);

        User::create([
            'name' => 'Cashier Jakarta',
            'email' => 'cashier.jkt@syakamarket.com',
            'password' => Hash::make('password'),
            'branch_id' => 1,
            'role' => 'cashier',
        ]);

        // =====================
// BANDUNG (ID 2)
// =====================

        User::create([
            'name' => 'Manager Bandung',
            'email' => 'manager.bdg@syakamarket.com',
            'password' => Hash::make('password'),
            'branch_id' => 2,
            'role' => 'manager',
        ]);

        User::create([
            'name' => 'Supervisor Bandung',
            'email' => 'supervisor.bdg@syakamarket.com',
            'password' => Hash::make('password'),
            'branch_id' => 2,
            'role' => 'supervisor',
        ]);

        User::create([
            'name' => 'Warehouse Bandung',
            'email' => 'warehouse.bdg@syakamarket.com',
            'password' => Hash::make('password'),
            'branch_id' => 2,
            'role' => 'warehouse',
        ]);

        User::create([
            'name' => 'Cashier Bandung',
            'email' => 'cashier.bdg@syakamarket.com',
            'password' => Hash::make('password'),
            'branch_id' => 2,
            'role' => 'cashier',
        ]);

        // =====================
// SURABAYA (ID 3)
// =====================

        User::create([
            'name' => 'Manager Surabaya',
            'email' => 'manager.sby@syakamarket.com',
            'password' => Hash::make('password'),
            'branch_id' => 3,
            'role' => 'manager',
        ]);

        User::create([
            'name' => 'Supervisor Surabaya',
            'email' => 'supervisor.sby@syakamarket.com',
            'password' => Hash::make('password'),
            'branch_id' => 3,
            'role' => 'supervisor',
        ]);

        User::create([
            'name' => 'Warehouse Surabaya',
            'email' => 'warehouse.sby@syakamarket.com',
            'password' => Hash::make('password'),
            'branch_id' => 3,
            'role' => 'warehouse',
        ]);

        User::create([
            'name' => 'Cashier Surabaya',
            'email' => 'cashier.sby@syakamarket.com',
            'password' => Hash::make('password'),
            'branch_id' => 3,
            'role' => 'cashier',
        ]);

        // =====================
// MEDAN (ID 4)
// =====================

        User::create([
            'name' => 'Manager Medan',
            'email' => 'manager.mdn@syakamarket.com',
            'password' => Hash::make('password'),
            'branch_id' => 4,
            'role' => 'manager',
        ]);

        User::create([
            'name' => 'Supervisor Medan',
            'email' => 'supervisor.mdn@syakamarket.com',
            'password' => Hash::make('password'),
            'branch_id' => 4,
            'role' => 'supervisor',
        ]);

        User::create([
            'name' => 'Warehouse Medan',
            'email' => 'warehouse.mdn@syakamarket.com',
            'password' => Hash::make('password'),
            'branch_id' => 4,
            'role' => 'warehouse',
        ]);

        User::create([
            'name' => 'Cashier Medan',
            'email' => 'cashier.mdn@syakamarket.com',
            'password' => Hash::make('password'),
            'branch_id' => 4,
            'role' => 'cashier',
        ]);

        // =====================
// MAKASSAR (ID 5)
// =====================

        User::create([
            'name' => 'Manager Makassar',
            'email' => 'manager.mks@syakamarket.com',
            'password' => Hash::make('password'),
            'branch_id' => 5,
            'role' => 'manager',
        ]);

        User::create([
            'name' => 'Supervisor Makassar',
            'email' => 'supervisor.mks@syakamarket.com',
            'password' => Hash::make('password'),
            'branch_id' => 5,
            'role' => 'supervisor',
        ]);

        User::create([
            'name' => 'Warehouse Makassar',
            'email' => 'warehouse.mks@syakamarket.com',
            'password' => Hash::make('password'),
            'branch_id' => 5,
            'role' => 'warehouse',
        ]);

        User::create([
            'name' => 'Cashier Makassar',
            'email' => 'cashier.mks@syakamarket.com',
            'password' => Hash::make('password'),
            'branch_id' => 5,
            'role' => 'cashier',
        ]);
    }
}