<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);

        // Create test user only if it doesn't already exist
        // User::firstOrCreate(
        //     ['email' => 'test@example.com'],
        //     ['name'  => 'Test User', 'password' => bcrypt('password')]
        // );

        // Generate Arabic categories, brands, and products
        // Category::factory(5)->create();
        // Brand::factory(5)->create();
        // Product::factory(20)->create();
    }
}
