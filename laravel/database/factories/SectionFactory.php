<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Section;
use Faker\Generator as Faker;

$factory->define(Section::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'description' => $faker->realText(500),
        'logo' => null,
    ];
});
