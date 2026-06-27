<?php

namespace Tests\Feature;

use App\Models\Category;
use Tests\TestCase;

class CategoryManagementTest extends TestCase
{
    public function test_database_seeder_creates_default_categories(): void
    {
        $this->artisan('migrate:fresh', [
            '--path' => 'database/migrations/2025_06_20_000001_create_categories_table.php',
            '--database' => 'sqlite',
        ]);

        $this->artisan('db:seed', ['--class' => 'CategorySeeder']);

        $this->assertTrue(Category::count() > 0);
        $this->assertDatabaseHas('categories', ['category_name' => 'Electronics']);
    }
}
