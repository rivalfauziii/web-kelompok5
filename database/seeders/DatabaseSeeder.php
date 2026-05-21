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

        /*
        |--------------------------------------------------------------------------
        | MANAGER
        |--------------------------------------------------------------------------
        */

        User::create([

            'name' => 'Manager Toko',
            'email' => 'manager@syakamarket.com',
            'password' => Hash::make('password'),

            'role' => 'manager',

        ]);

        /*
        |--------------------------------------------------------------------------
        | CASHIER
        |--------------------------------------------------------------------------
        */

        User::create([

            'name' => 'Kasir Toko',
            'email' => 'cashier@syakamarket.com',
            'password' => Hash::make('password'),
            'branch_id' => 1,
            'role' => 'cashier',

        ]);

        /*
        |--------------------------------------------------------------------------
        | WAREHOUSE
        |--------------------------------------------------------------------------
        */

        User::create([

            'name' => 'Warehouse Staff',
            'email' => 'warehouse@syakamarket.com',
            'password' => Hash::make('password'),

            'role' => 'warehouse',

        ]);

        /*
        |--------------------------------------------------------------------------
        | SUPERVISOR
        |--------------------------------------------------------------------------
        */

        User::create([

            'name' => 'Supervisor Toko',
            'email' => 'supervisor@syakamarket.com',
            'password' => Hash::make('password'),

            'role' => 'supervisor',

        ]);

    }
}