<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Application
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $town
 * @property string $postal_code
 * @property string $phone
 * @property string $date_of_birth
 * @property string $description
 * @property string $person_picture
 * @property string $bike_picture
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $age
 * @method static \Illuminate\Database\Eloquent\Builder|Application newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application query()
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereBikePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application wherePersonPicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereTown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereUpdatedAt($value)
 */
	class Application extends \Eloquent {}
}

namespace App{
/**
 * App\Event
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $location
 * @property string $timestamp
 * @property string|null $timestamp_end
 * @property string $picture
 * @property int $full_day
 * @property string|null $location_link
 * @property string|null $facebook_link
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\EventApplication[] $eventApplications
 * @property-read int|null $event_applications_count
 * @property-read mixed $day
 * @property-read mixed $end_time
 * @property-read mixed $formatted_time
 * @property-read mixed $month
 * @property-read mixed $start_time
 * @property-read mixed $year
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereFacebookLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereFullDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereLocationLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event wherePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereTimestampEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedAt($value)
 */
	class Event extends \Eloquent {}
}

namespace App{
/**
 * App\EventApplication
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $event_id
 * @property string $name
 * @property string $phone
 * @property-read \App\Event $event
 * @method static \Illuminate\Database\Eloquent\Builder|EventApplication newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventApplication newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventApplication query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventApplication whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventApplication whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventApplication whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventApplication whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventApplication wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventApplication whereUpdatedAt($value)
 */
	class EventApplication extends \Eloquent {}
}

namespace App{
/**
 * App\Gallery
 *
 * @property int $id
 * @property string $title
 * @property int $is_private
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $picture_columns
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Picture[] $pictures
 * @property-read int|null $pictures_count
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery query()
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereIsPrivate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereUpdatedAt($value)
 */
	class Gallery extends \Eloquent {}
}

namespace App{
/**
 * App\Order
 *
 * @property int $id
 * @property int $user_id
 * @property int $fulfilled
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\OrderHasProduct[] $orderHasProducts
 * @property-read int|null $order_has_products_count
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Query\Builder|Order onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereFulfilled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Order withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Order withoutTrashed()
 */
	class Order extends \Eloquent {}
}

namespace App{
/**
 * App\OrderHasProduct
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Order $order
 * @property-read \App\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|OrderHasProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderHasProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderHasProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderHasProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderHasProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderHasProduct whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderHasProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderHasProduct whereUpdatedAt($value)
 */
	class OrderHasProduct extends \Eloquent {}
}

namespace App{
/**
 * App\Picture
 *
 * @property int $id
 * @property int $gallery_id
 * @property string $url
 * @property int $is_private
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $is_featured
 * @property-read \App\Gallery $gallery
 * @property-read mixed $dimensions
 * @method static \Illuminate\Database\Eloquent\Builder|Picture newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Picture newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Picture query()
 * @method static \Illuminate\Database\Eloquent\Builder|Picture whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Picture whereGalleryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Picture whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Picture whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Picture whereIsPrivate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Picture whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Picture whereUrl($value)
 */
	class Picture extends \Eloquent {}
}

namespace App{
/**
 * App\Product
 *
 * @property int $id
 * @property int $updated_by
 * @property string $title
 * @property string|null $description
 * @property int $price
 * @property string $product_picture
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereProductPicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedBy($value)
 */
	class Product extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $api_token
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $profile_picture
 * @property string|null $description
 * @property string $role
 * @property-read mixed $profile_picture_dimensions
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfilePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

