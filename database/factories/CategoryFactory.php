<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->word(); // nom unique
        $slug = Str::slug($name); // slug à partir du nom

        // Ici on génère un nom d'image fictif (à remplacer par ton propre système si tu copies une vraie image)
        $imageName = 'default.png'; // ou ex: fake()->uuid().'.png'

        return [
            'name' => $name,
            'slug' => $slug,
            'image' => $imageName, // nom de l’image (tu peux gérer l'image dans un seeder à part si besoin)
        ];
    }
}
