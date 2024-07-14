<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ApiKey;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create an initial API key for the user
        ApiKey::create([
            'key' => 'lIwhMvlohsg4pSevgNFsLeYvflD0h1Dc',
            'name' => 'Initial API Key',
        ]);
    }
}
