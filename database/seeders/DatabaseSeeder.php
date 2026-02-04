<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Use env overrides for seeder defaults to avoid hard-coded test data
        User::factory()->create([
            'name' => env('SEEDER_USER_NAME', 'Admin'),
            'email' => env('SEEDER_USER_EMAIL', 'admin@example.com'),
        ]);
    }
}
