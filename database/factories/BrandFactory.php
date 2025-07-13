<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Une Factory définit la structure des données fictives pour un modèle donné
 * mais ne crée aucune donnée dans la base toute seule. Elle sert juste
 * de modèle de fabrication.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->company;
        $image = $this->faker->imageUrl(200, 200, 'business', false); // URL fictive
        $slug = Str::slug($name);
        return [
            'name' => $name,
            'slug' => $slug,
            'image' => $image
        ];
    }
}
