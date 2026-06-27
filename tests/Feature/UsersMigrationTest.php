<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UsersMigrationTest extends TestCase
{
    public function test_users_table_includes_remember_token_column(): void
    {
        $this->artisan('migrate:fresh', [
            '--path' => 'database/migrations/0001_01_01_000000_create_users_table.php',
            '--database' => 'sqlite',
        ]);

        $this->artisan('migrate', [
            '--path' => 'database/migrations/2026_06_27_000001_add_remember_token_to_users_table.php',
            '--database' => 'sqlite',
        ]);

        $this->assertTrue(Schema::connection('sqlite')->hasColumn('users', 'remember_token'));
    }
}
