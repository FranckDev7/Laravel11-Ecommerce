<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crée un admin
        User::factory()->create([
            'name' => 'Franck MUZABA',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('ronaldo7@'), // ou Hash::make(...)
        ]);

        User::factory()->count(50)->create();
    }
}
