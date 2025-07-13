<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// relation "plusieurs-à-un" (many-to-one) ou "belongsto" en Eloquent (Laravel ORM).
// utilisée dans Laravel Eloquent pour indiquer qu’un modèle enfant appartient(lié)
// à un modèle parent
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $short_description
 * @property string $description
 * @property string $regular_price
 * @property string|null $sale_price
 * @property string $SKU
 * @property string $stock_status
 * @property int $featured
 * @property int $quantity
 * @property string|null $image
 * @property string|null $images
 * @property int|null $category_id
 * @property int|null $brand_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Brand|null $brand
 * @property-read \App\Models\Category|null $category
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereRegularPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSKU($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSalePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereStockStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    // Le trait HasFactory sert à activer la fonctionnalité des factories
    // sur un modèle Eloquent. les factories sont des instances du modèle
    // pour les tests ou le peuplement de la base de données.
    use HasFactory;

    public function category()
    {
        // La clé étrangère category_id permet de savoir à quelle catégorie
        // appartient(lié) chaque produit
        return $this->belongsTo(Category::class, 'category_id');
    }


    public function brand()
    {
        // La clé étrangère brand_id permet de savoir à quelle marque
        // appartient(lié) chaque produit
        return $this->belongsTo(Brand::class, 'brand_id');
    }
}
