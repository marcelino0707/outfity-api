<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use App\Models\Transaction;
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

        Product::create([
            'title' => 'Celana sekolah',
            'category' => 'long pant',
            'price' => 32000,
            'description' => 'celana panjang anak SMA',
        ]);

        Cart::create([
            'user_id' => 2,
            'title_cart' => 'Belanjaan Diskonan',
        ]);

        CartDetail::create([
            'cart_id' => 1,
            'product_id' => 1,
            'quantity' => 3,
        ]);

        CartDetail::create([
            'cart_id' => 1,
            'product_id' => 2,
            'quantity' => 4,
        ]);

        Transaction::create([
            'cart_id' => 1,
            'user_id' => 1,
            'invoice_number' => 'INV001',
            'total_amount' => 150000.00,
        ]);
    }
}
