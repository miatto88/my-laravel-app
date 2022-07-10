<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Todo;
use Faker\Generator as Faker;

$factory->define(Todo::class, function (Faker $faker) {
    return [
        "user_id" => $faker->randomElement([1, 2, 3]),
        "title" => $faker->randomElement([
            "Laravel勉強",
            "git勉強",
            "引っ越し準備",
            "服買い出し"
        ]),
        "status" => 0
    ];
});
