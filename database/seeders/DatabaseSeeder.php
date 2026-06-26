<?php

namespace Database\Seeders;

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
        $this->call(ProductSeeder::class);

        User::firstOrCreate(
            ['email' => 'admin@furninest.test'],
            [
                'name' => 'Admin FurniNest',
                'password' => Hash::make('password'),
                'phone' => '081234567890',
                'role' => 'ADMIN',
                'active' => true,
            ]
        );
    }
}
