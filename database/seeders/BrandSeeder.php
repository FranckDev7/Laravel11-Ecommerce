<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class BrandSeeder extends Seeder
{
    /**
     * Exécute le seeder pour insérer les marques et générer les images associées.
     */
    public function run(): void
    {
        // Dossier de destination des logos générés
        $folder = public_path('uploads/brands');

        // Créer le dossier s'il n'existe pas
        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0755, true);
        }

        // Liste des marques à insérer
        $brands = [
            // Marques américaines
            "Ralph Lauren", "Gucci", "Adidas", "Calvin Klein", "Tommy Hilfiger","Michael Kors",
            "Marc Jacobs", "Levi’s", "Guess", "Coach", "Tory Burch","Kate Spade", "Brooks Brothers",
            "Vera Wang", "Nike", "Supreme", "The North Face", "Abercrombie & Fitch", "Hollister",
            "GAP","American Eagle","Vans", "Stüssy", "Off-White", "Tom Ford", "Alexander Wang",

            // Marques françaises
            "Louis Vuitton", "Chanel", "Dior", "Yves Saint Laurent", "Hermès","Givenchy", "Balmain", "Lanvin",
            "Chloé", "Céline", "Lacoste", "Jacquemus", "Jean Paul Gaultier", "Isabel Marant", "Sandro",
            "Maje", "The Kooples", "A.P.C.", "Zadig & Voltaire", "Carven", "Courrèges", "Agnes b.",
            "Pierre Cardin", "Sonia Rykiel", "Christian Louboutin",
        ];

        foreach ($brands as $brandName) {
            $filename = 'brand-' . Str::slug($brandName) . '.jpg';
            $filepath = $folder . '/' . $filename;

            // Générer l'image uniquement si elle n'existe pas
            if (!file_exists($filepath)) {
                $colors = [
                    '#ff0000','#0000ff','#3cb371','#ee82ee', '#ffa500',
                    '#6a5acd','#878847','#876247','#876278'
                ];

                // array_rand() : fonction PHP qui choisit aléatoirement une clé (index) dans le tableau donné.
                $bgColor = $colors[array_rand($colors)];
                $fontColor = '#404040';

                // Créer une image 200x200 avec fond
                $img = Image::canvas(200, 200, $bgColor);

                /**
                 * Extraire les initiales (ex: "Louis Vuitton" → "LV")
                 * preg_split : fonction PHP qui découpe une chaîne de caractères
                 * (comme explode(), mais avec des expressions régulières).
                 *
                 * 1ere étape : strtoupper : convertit la chaîne en majuscules.
                 * 2ere étape : preg_split : divise la chaîne en mots en utilisant les espaces,
                 * tirets et parenthèses comme séparateurs.
                 */
                $words = preg_split('/[\s\-\.()]+/', strtoupper($brandName));
                $initials = ''; // contiendra les initiales du nom de la marque.

                foreach ($words as $word) {
                    /**
                     * preg_match : fonction PHP qui permet de vérifier si une chaîne correspond à une expression régulière.
                     */
                    if (preg_match('/^[A-Z]/', $word)) {
                        $initials .= $word[0];
                    }
                }

                /**
                 * substr et mb_substr : fonctions qui servent à extraire une partie d’une chaîne de caractères
                 * à la difference de substr, mb_substr gère correctement les caractères multibytes (comme les accents).
                 */
                if (!$initials) {
                    $initials = strtoupper(mb_substr($brandName, 0, 1));
                }

                /**
                 * Ajouter les initiales sur l’image
                 * text() : méthode qui permet  d’écrire du texte dans l’image.
                 * function ($font) { ... } : Fonction anonyme (callback) utilisée pour configurer l’apparence du texte.
                 * $font : objet de type Intervention\Image\Gd\Font qui implémente l'interface Intervention\Image\Interfaces\FontInterface
                 *
                 */

                $img->text($initials, 100, 100, function ($font) use ($fontColor) {

                    // On définit le chemin vers la police personnalisée
                    $fontPath = public_path('fonts/Montserrat-Bold.ttf');

                    // vérifie que ce fichier de police existe bien avant de l'utiliser
                    if (file_exists($fontPath)) {
                        // Si la police existe, on l'applique pour le texte
                        $font->file($fontPath);
                    }

                    // On définit la taille de la police du texte à 25 pixels
                    $font->size(80);

                    // On définit la couleur du texte avec un gris foncé (code hexadécimal)
                    $font->color($fontColor);

                    // On centre le texte horizontalement par rapport au point (150,150)
                    $font->align('center');

                    // On centre le texte verticalement par rapport au point (150,150)
                    $font->valign('center');
                });

                // Sauvegarder l'image
                $img->save($filepath);
            }

            // Enregistrer la marque en base de données
            Brand::create([
                'name' => $brandName,
                'slug' => Str::slug($brandName),
                'image' => $filename,
            ]);
        }
    }
}
