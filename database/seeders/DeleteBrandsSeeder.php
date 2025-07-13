<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DeleteBrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Supprime toutes les lignes de la table brands
        // truncate() : méthode du modèle Eloquent qui permet de vider une table rapidement.
        // façade DB de Laravel,  qui permet d’interagir avec la base de données
        // statement : Méthode de la façade DB qui exécute une requête SQL brute
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        Brand::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $folder = public_path('uploads/brands');

        // Si le dossier existe
        if (File::exists($folder)) {
            // Récupérer tous les fichiers (non les dossiers)
            $files = File::files($folder);

            foreach ($files as $file) {
                File::delete($file);
            }

        } else {
            $this->command->warn("Le dossier uploads/brands/ n'existe pas.");
        }
    }
}
