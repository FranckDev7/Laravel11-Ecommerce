<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $phone
 * @property string $locality
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $counrty
 * @property string|null $landmark
 * @property string $zip
 * @property string $type
 * @property int $isdefault
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCounrty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereIsdefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereLandmark($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereLocality($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereZip($value)
 * @mixin \Eloquent
 */
class Address extends Model
{
    // Déclare les attributs pouvant être assignés en masse
    // lors de la création ou mise à jour d'une commande
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'zip',
        'state',
        'city',
        'address',
        'locality',
        'landmark',
        'isdefault',
        'country',
        'type',
    ];
}
