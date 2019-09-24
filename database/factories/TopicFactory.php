<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Topic;
use Faker\Generator as Faker;

$factory->define(Topic::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(4),
        'description' => $faker->text(),
    ];
});
