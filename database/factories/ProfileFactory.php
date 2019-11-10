<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Profile;
use Faker\Generator as Faker;

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'birthday' => now()->toDateString(),
        'gender' => rand(1,2) % 2 == 0 ? 'male' : 'female'
    ];
});
