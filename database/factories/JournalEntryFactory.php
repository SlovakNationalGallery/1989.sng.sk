<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\JournalEntry;
use Faker\Generator as Faker;

$factory->define(JournalEntry::class, function (Faker $faker) {
    return [
        'written_at' => $faker->date(),
        'content' => $faker->randomHtml(),
    ];
});
