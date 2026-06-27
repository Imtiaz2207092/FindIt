<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Electronics',
            'Wallets and IDs',
            'Clothing',
            'Books and Stationery',
            'Accessories',
            'Bags and Luggage',
            'Personal Care',
            'Documents',
        ];

        foreach ($categories as $name) {
            try {
                // Check if category already exists
                if (!Category::where('category_name', $name)->exists()) {
                    // Use raw insert to avoid Oracle RETURNING issues
                    DB::table('categories')->insert([
                        'category_name' => $name,
                    ]);
                }
            } catch (\Throwable $e) {
                \Log::warning("Category seed failed for '{$name}': {$e->getMessage()}");
            }
        }
    }
}
