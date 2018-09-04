<?php

use Faker\Generator as Faker;

$factory->define(App\Models\M_Religion::class, function (Faker $faker) {
    return [
        'religion_name' => $faker->country,
    ];
});
