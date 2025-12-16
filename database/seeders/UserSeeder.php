<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@flowerstore.com',
            'password' => Hash::make('password'),
            'role' => UserRole::ADMIN,
            'email_verified_at' => now(),
        ]);

        // Create Customer User
        User::create([
            'name' => 'John Doe',
            'email' => 'customer@flowerstore.com',
            'password' => Hash::make('password'),
            'role' => UserRole::CUSTOMER,
            'email_verified_at' => now(),
        ]);

        $this->command->info('Users seeded successfully!');
    }
}


