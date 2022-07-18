<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Aggreagate;
use Faker\Generator as Faker;

$factory->define(Aggreagate::class, function (Faker $faker) {
    return [
        'aggreacate_new_tasks' => '0',
        'aggreacate_complete_tasks' => '0',
        'aggreacate_incomplete_tasks' => '0',
    ];
});
