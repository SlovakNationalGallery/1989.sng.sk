<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Topic;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Topic::class, function (Faker $faker) {
    $name = $faker->sentence(4);
    return [
        'name' => $name,
        'slug' => Str::slug($name, '-'),
        'description' => $faker->text(),
        'cover_image' => $faker->image(),
    ];
});
