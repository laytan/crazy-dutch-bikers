<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Gallery;
use App\Picture;
use Faker\Generator as Faker;

$factory->define(Picture::class, function (Faker $faker) {
    return [
        'url' => $faker->imageUrl,
        'is_private' => false,
        'gallery_id' => fn() => factory(Gallery::class)->create()->id,
    ];
});
