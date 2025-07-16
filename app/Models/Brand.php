<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Une relation un à un à plusieurs (One to Many / Has Many) est utilisée
// pour définir des relations où un modèle unique est le parent
// à un ou plusieurs modèles enfants
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereUpdatedAt($value)
 * @method static \Database\Factories\BrandFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
class Brand extends Model
{
    // Le trait HasFactory sert à activer la fonctionnalité des factories
    // sur un modèle Eloquent. les factories sont des instances du modèle
    // pour les tests ou le peuplement de la base de données.
    use HasFactory;

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
