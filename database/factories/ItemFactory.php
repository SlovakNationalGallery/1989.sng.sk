<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Item;
use Faker\Generator as Faker;

$factory->define(Item::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(4),
        'type' => $faker->randomElement(['text', 'quotation', 'image', 'sound', 'video', 'comment']),
        'text' => $faker->text(),
        // 'file' => $faker->file(), @todo
    ];
});
