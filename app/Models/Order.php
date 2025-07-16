<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int $user_id
 * @property string $subtotal
 * @property string $discount
 * @property string $tax
 * @property string $total
 * @property string $name
 * @property string $phone
 * @property string $locality
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string|null $landmark
 * @property string $zip
 * @property string $type
 * @property string $status
 * @property int $is_shipping_different
 * @property string|null $delivered_date
 * @property string|null $canceled_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItem> $orderItems
 * @property-read int|null $order_items_count
 * @property-read \App\Models\Transaction|null $transaction
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCanceledDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereDeliveredDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereIsShippingDifferent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereLandmark($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereLocality($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereZip($value)
 * @mixin \Eloquent
 */
class Order extends Model
{
    use HasFactory;

    // Déclare les attributs pouvant être assignés en masse
    // lors de la création ou mise à jour d'une commande
    protected $fillable = [
        'user_id',
        'subtotal',
        'discount',
        'tax',
        'total',
        'name',
        'phone',
        'district',
        'city',
        'country',
        'landmark',
        'code_postal',   
    ];



    /**
     * Relation Inverse de OneToMany(hasMany) : Order appartient à un utilisateur (User).
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, Order>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation OneToMany(hasMany) : Order a plusieurs articles de commande (OrderItem).
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<OrderItem, Order>
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relation One To One (hasOne) : Order a une seule transaction (Transaction).
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<Transaction, Order>
     */
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
