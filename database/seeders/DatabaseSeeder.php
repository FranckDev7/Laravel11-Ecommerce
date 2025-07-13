<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Méthode permettant d’exécuter plusieurs seeders à la suite.
        $this->call([
            UserSeeder::class,
            BrandSeeder::class,
            CategorySeeder::class
        ]);
    }
}
