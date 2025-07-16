<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
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
	class Address extends \Eloquent {}
}

namespace App\Models{
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
	class Brand extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $image
 * @property string|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static \Database\Factories\CategoryFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $code
 * @property string $type
 * @property string $value
 * @property string $cart_value
 * @property string $expiry_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereCartValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereValue($value)
 * @mixin \Eloquent
 */
	class Coupon extends \Eloquent {}
}

namespace App\Models{
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
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $product_id
 * @property int $order_id
 * @property string $price
 * @property int $quantity
 * @property string|null $options
 * @property int $rstatus
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Order $order
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereRstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class OrderItem extends \Eloquent {}
}

namespace App\Models{
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
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $order_id
 * @property string $mode
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereUserId($value)
 * @mixin \Eloquent
 */
	class Transaction extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $mobile
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $utype ADM for Admin and USR for User or Customer
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUtype($value)
 * @mixin \Eloquent
 */
	class User extends \Eloquent {}
}

