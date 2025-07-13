<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DeleteCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Category::truncate();   // Supprime toutes les lignes de la table categories
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $folder = public_path('uploads/categories');

        // Si le dossier existe
        if (File::exists($folder)) {
            // Récupérer tous les fichiers (non les dossiers)
            $files = File::files($folder);

            foreach ($files as $file) {
                File::delete($file);
            }

        } else {
            $this->command->warn("Le dossier uploads/categories/ n'existe pas.");
        }
    }
}
