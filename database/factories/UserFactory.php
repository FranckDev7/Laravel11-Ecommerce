<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Méthode principale d’une Factory qui retourne un tableau
     * de valeurs fictives à utiliser pour créer un User.
     *
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /**
         * Liste des préfixes autorisés
         * Ensuite, choisit soit 8 soit 9
         * Puis génère 8 chiffres aléatoires
         */
        $prefixes = ['081', '082', '099', '080', '084', '085', '089'];

        return [
            'name' => fake()->name(), // Génére un nom aléatoire (ex: “Jean Dupont”).
            'email' => fake()->unique()->safeEmail(), // Génère une adresse e-mail unique et sécurisée (ex: exemple@mail.com).
            'email_verified_at' => now(), // Marque l’e-mail comme vérifié maintenant (now() retourne la date actuelle).

            /**
             * Si static::$password est déjà défini, on le réutilise.
             * Sinon, on le remplit avec Hash::make('password').
             * But : ne hasher "password" qu’une seule fois
             */
            'password' => static::$password ??= Hash::make('password'),

            // Génération du mobile
            'mobile' => fake()->randomElement($prefixes) . fake()->numerify('#######'),

            // Génère un token de session de 10 caractères, utilisé pour la fonction "se souvenir de moi".
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
