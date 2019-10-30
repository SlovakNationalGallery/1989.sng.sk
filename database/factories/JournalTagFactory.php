<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\JournalTag;
use Faker\Generator as Faker;

$factory->define(JournalTag::class, function (Faker $faker) {
    return [
        'subject' => $faker->word(),
    ];
});
