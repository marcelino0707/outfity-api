<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'Marcelino Admin',
            'username' => 'admin1',
            'password' => Hash::make('Qwerty123!'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Marcelino User',
            'username' => 'marcelino',
            'password' => Hash::make('Test123!'),
            'role' => 'user',
        ]);

        Product::create([
            'title' => 'Baju Oversize Hitam Muda',
            'category' => 'tshirt',
            'price' => 150000,
            'description' => 'baju kece buat anak muda',
        ]);

        Product::create([
            'title' => 'Tas bocil',
            'category' => 'bag',
            'price' => 75000,
            'description' => 'tas keren buat bocil',
        ]);
    }
}
