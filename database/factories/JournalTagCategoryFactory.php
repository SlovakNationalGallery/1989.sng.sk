<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\JournalTagCategory;
use Faker\Generator as Faker;

$factory->define(JournalTagCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->word(),
    ];
});
